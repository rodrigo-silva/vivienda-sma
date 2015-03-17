<?php
 echo TbHtml::icon(TbHtml::ICON_GLASS);   //HIDDEN dropdown list
   echo TbHtml::dropDownList('vinculo', '', $vinculosFemeninosList, array('id'=>'vinculos-femeninos-combo', 'class'=>'hide'));
   echo TbHtml::dropDownList('vinculo', '', $vinculosMasculinosList, array('id'=>'vinculos-masculinos-combo', 'class'=>'hide'));

   $this->widget('bootstrap.widgets.TbModal', array(
      'id' => 'convivienteModal',
      'header' => 'Buscar Persona',
      'content' => $this->renderPartial('new', array('model'=>$findPersonaForm), true),
      'onHidden' => 'js:function(){resetModal()}'
   )); 

   echo TbHtml::button('Agregar persona', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'id'=>'add-persona-btn',
      'data-toggle' => 'modal',
      'data-target' => '#convivienteModal',)
   );
?>

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
   </tbody>
</table>

<?php   Yii::app()->clientScript->registerScript('script',
<<<JS
   var findPersonaForm = jQuery('#convivienteModal form').clone();
   var vinculosMasculinosCombo = jQuery('#vinculos-masculinos-combo');
   var vinculosFemeninosCombo = jQuery('#vinculos-femeninos-combo');
   

   //init findPersonaForm
   jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
   jQuery('#convivienteModal form button').click(onFindPersonaClick);
   

   function onFindPersonaClick() {
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
      jQuery('<tr/>')
         .append(jQuery('<td/>').html(data.nombre))
         .append(jQuery('<td/>').html(data.apellido))
         .append(jQuery('<td/>').html(data.dni))
         .append(jQuery('<td/>').append(combo.show()))
         .append(jQuery('<td/>').append(jQuery('<input/>', {type:"checkbox"})))
         .append(jQuery('<td/>').append(jQuery('<input/>', {type:"radio", name:"cotitular"})))
         .append(jQuery('<td/>').append(jQuery('<span/>', {class: "icon-remove"})))
         .appendTo('table#grupo-conviviente tbody');
   }

   resetModal = function() {
      jQuery('#convivienteModal form').replaceWith(findPersonaForm.clone());
      jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
      jQuery('#convivienteModal form button').click(onFindPersonaClick);     
   }


JS
   , CClientScript::POS_READY);

?>