<?php
   //HIDDEN dropdown list
   echo TbHtml::dropDownList('vinculo', '', $vinculosFemeninosList, array('id'=>'vinculos-femeninos-combo', 'class'=>'hide'));
   echo TbHtml::dropDownList('vinculo', '', $vinculosMasculinosList, array('id'=>'vinculos-masculinos-combo', 'class'=>'hide'));

   $this->widget('bootstrap.widgets.TbModal', array(
      'id' => 'convivienteModal',
      'header' => 'Confeccion grupo conviviente',
      'content' => $this->renderPartial('new', array('model'=>$findPersonaForm), true),
      'onHidden' => 'js:function(){resetModal()}',
      'onShow' => 'js:function(){resetAdvice()}'
   )); 

   // VIEW
   echo CHtml::tag('legend', array(), 'Detalles foo bar baz');
   echo CHtml::tag('div', array('class'=>'alert alert-info'), "Solicitud numero $solicitud->numero");
   echo TbHtml::button('Agregar persona', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'id'=>'add-persona-btn',
      'data-toggle' => 'modal',
      'data-target' => '#convivienteModal',)
   );
?>
<div id="advice-container"></div>
<table class="table table-striped" id="grupo-conviviente">
   <thead>
      <tr>
         <th>Nombre</th>
         <th>Apellido</th>
         <th>DNI</th>
         <th>Vinculo</th>
         <th>Es Solicitante</th>
         <th>Cotitular</th>
         <th></th>
      </tr>
   </thead>
   <tbody>
      <tr>
         <th><?php echo "$titular->nombre"?></th>
         <th><?php echo "$titular->apellido"?></th>
         <th class="dni"><?php echo "$titular->dni"?></th>
         <th><?php echo ""?></th>
         <th><?php echo "Si"?></th>
         <th><?php echo "Titular"?></th>
         <th><?php echo  ""?></th>
      </tr>
   </tbody>
</table>

<script type="text/javascript">
   var addedDnis = []
   var findPersonaForm = jQuery('#convivienteModal form').clone();
   var vinculosMasculinosCombo = jQuery('#vinculos-masculinos-combo');
   var vinculosFemeninosCombo = jQuery('#vinculos-femeninos-combo');
   

   //init findPersonaForm
   jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
   jQuery('#convivienteModal form button').click(onFindPersonaClick);
   

   function onFindPersonaClick() {
      if(isPresent(jQuery('#convivienteModal form').find('input#SolicitudFindUserForm_dni').val()))  {
         jQuery('#advice-container').attr('class', 'alert alert-error').text("El DNI ya existe en la lista")
         jQuery('#convivienteModal').modal('hide');
         return;
      }

      $.post('/Solicitud/_getconviviente', jQuery('#convivienteModal form').serialize())
         .done(findPersonaSuccessCallback)
         .fail(findPersonaErrorCallback);
   }

   function findPersonaSuccessCallback(data, status, jqXHR ) {
      if(jqXHR.getResponseHeader('Content-Type') == 'application/json') {
         addConvivienteSuccessCallback(data);
      } else {
         jQuery('#convivienteModal form').replaceWith(data);
         jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
         jQuery('#convivienteModal form button').click(onAddConvivienteButton);
      }
   }

   function findPersonaErrorCallback(data) {
      jQuery('#convivienteModal form').replaceWith(data.responseText);
      jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
      jQuery('#convivienteModal form button').click(onFindPersonaClick);
   }

   function onAddConvivienteButton() {
      var form = jQuery('#convivienteModal form');
      $.post(form.attr('action'), form.serialize(), null, 'json').done(addConvivienteSuccessCallback).fail(addConvivienteErrorCallback);
   }

   function addConvivienteErrorCallback(data) {
      jQuery('#convivienteModal form').replaceWith(data.responseText);
      jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
      jQuery('#convivienteModal form button').click(onAddConvivienteButton);
   }

   function addConvivienteSuccessCallback(data) {
      jQuery('#convivienteModal').modal('hide');
      jQuery('#convivienteModal form').replaceWith(findPersonaForm.clone());
      jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
      jQuery('#convivienteModal form button').click(onFindPersonaClick);
      if(data.sexo == 'M') {
         var combo = vinculosMasculinosCombo.clone();
      } else {
         var combo = vinculosFemeninosCombo.clone();
      }
      var removeButton = jQuery('<span/>', {class: "icon-remove"}).click(function(){
         removeDni($(this).parent().siblings(".dni").text())
         $(this).parents('tr').remove()
      })
      jQuery('<tr/>')
         .append(jQuery('<td/>').html(data.nombre))
         .append(jQuery('<td/>').html(data.apellido))
         .append(jQuery('<td/>').addClass('dni').html(data.dni))
         .append(jQuery('<td/>').append(combo.show()))
         .append(jQuery('<td/>').append(jQuery('<input/>', {type:"checkbox"})))
         .append(jQuery('<td/>').append(jQuery('<input/>', {type:"radio", name:"cotitular"})))
         .append(jQuery('<td/>').append(removeButton))
         .appendTo('table#grupo-conviviente tbody');
      addedDnis.push(data.dni);
   }


   isPresent = function(dni) {
      for (var i = 0; i < addedDnis.length; i++) {
         if(addedDnis[i] == dni) {
            return true;
         }
      }
   }

    removeDni = function(dni) {
      for (var i = 0; i < addedDnis.length; i++) {
         if(addedDnis[i] == dni) {
            addedDnis.splice(i, 1)
         }
      }
   }

   resetModal = function() {
      jQuery('#convivienteModal form').replaceWith(findPersonaForm.clone());
      jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
      jQuery('#convivienteModal form button').click(onFindPersonaClick);     
   }

   resetAdvice = function() {
      jQuery('#advice-container').attr('class', '').text("")
         
   }

</script>