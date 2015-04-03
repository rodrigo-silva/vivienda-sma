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
   $domicilioCompleto = $solicitud->domicilio->calle . " " . $solicitud->domicilio->altura;
   echo CHtml::tag('div', array('class'=>'alert alert-success'), "Se ha creado la solicitud numero $solicitud->numero, en estado {$solicitud->estado->nombre}");
?>




<?php echo CHtml::tag('legend', array(), "Detalles de la vivienda en domicilio $domicilioCompleto" ); ?>

<h4>Detalle servicios</h4>
<div class="row">
<div class="span6">
   
<table class="table table-striped" id="servicios-table">
   <thead>
      <tr>
         <th>Servicio</th>
         <th>Disponible</th>
         <th><?php echo TbHtml::tooltip("Posee medidor", "#", "No indicar si esta 'colgado' del servicio.")?></th>
         <th><?php echo TbHtml::tooltip("Es compartido", "#", "En el caso que pague en forma conjunta con otros vecinos")?></th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($this->getServicios() as $key => $value) {
         echo "<tr>";
            echo CHtml::tag('td', array(), $value);
            echo CHtml::tag('td', array('class' =>'servicio-disponible', 'servicio-id'=>"$key"), TbHtml::checkBox('', false));
            echo CHtml::tag('td', array(), TbHtml::checkBox('', false));
            echo CHtml::tag('td', array(), TbHtml::checkBox('', false));
         echo "</tr>";
      }?>
   </tbody>
</table>
</div>
</div>

<h4>Detalles sanitarios</h4>
<div id="banios-container">
   <div class="control-group form-inline">
      <div class="controls">
         <label for="">Detalles del ba&ntilde;o:</label>
         <?php echo TbHtml::dropDownList('interno','', array('Externo', 'Interno')); ?>
         <?php echo TbHtml::dropDownList('completo','', array('Incompleto', 'Completo')); ?>      
         <?php echo TbHtml::checkBox('letrina', true, array('label'=>'Es Letrina')); ?>
      </div>
   </div>
</div>
<?php echo TbHtml::button('Agregar ba&ntilde;o', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'id'=>'add-banio-btn',
      'size' => TbHtml::BUTTON_SIZE_MINI)
   );
?>

<h4>Observaciones generales</h4>
<?php echo TbHtml::textArea('', '', array('rows' => 3, 'cols'=>8)); ?>


<?php
   echo CHtml::tag('legend', array(), "Grupo conviviente en domicilio $domicilioCompleto");
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
<div>
   <?php echo TbHtml::button('Agregar persona', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'id'=>'add-persona-btn',
      'data-toggle' => 'modal',
      'data-target' => '#convivienteModal',)
   );?>
</div>

<div>
   <?php echo TbHtml::button('Guardar en borrador', array('id'=>'submit-borrador-btn'));?>
</div>





<script type="text/javascript">
   //some wide used vars
   var addedDnis = []
   var findPersonaForm = jQuery('#convivienteModal form').clone();
   var vinculosMasculinosCombo = jQuery('#vinculos-masculinos-combo');
   var vinculosFemeninosCombo = jQuery('#vinculos-femeninos-combo');
   var detalleBanio = jQuery('.control-group.form-inline').clone();

   //init findPersonaForm
   jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
   jQuery('#convivienteModal form button').click(onFindPersonaClick);
   jQuery('td.servicio-disponible').click(onClickServicioDisponible);
   jQuery('#add-banio-btn').click(onAddDetalleBanio);
   jQuery('#submit-borrador-btn').click(onSubmit);

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

   function onClickServicioDisponible() {
      if(jQuery(this).find('input').prop('checked')) {
         jQuery(this).siblings().find('input').removeAttr('disabled')
      } else {
         jQuery(this).siblings().find('input').attr('disabled', 'disabled')
      }
   }

   function onAddDetalleBanio() {
      var removeButton = jQuery('<span/>', {class: "icon-remove"}).click(function(){
         jQuery(this).parents('.control-group').remove();
      })
      var detalle = detalleBanio.clone();
      detalle.find('.controls').append(removeButton)
      jQuery('#banios-container').append(detalle)

   }

   function onSubmit() {
      //servicios
      jQuery('#servicios-table tbody tr').each(function(i,e){})
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

   function submit(values) {
      var form = jQuery('<form/>', {
      action: '/Solicitud/confeccionGrupoConviviente',
      method: 'POST'
      });
      jQuery.each(values, function() {
         form.append(jQuery('<input/>', {
            type: 'hidden',
            name: this.name,
            value: this.value
         }));
      });
      form.appendTo('body').submit();
   } 

    jQuery('td.servicio-disponible').trigger('click')

</script>