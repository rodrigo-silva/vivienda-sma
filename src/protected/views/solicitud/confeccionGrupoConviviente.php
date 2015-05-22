<?php
   $titular = $solicitud->titular;
   //HIDDEN dropdown list
   echo TbHtml::dropDownList('vinculo', '', $vinculosFemeninosList, array('class'=>'vinculos-femeninos-combo hide'));
   echo TbHtml::dropDownList('vinculo', '', $vinculosMasculinosList, array('class'=>'vinculos-masculinos-combo hide'));
   $this->widget('bootstrap.widgets.TbModal', array(
      'id' => 'convivienteModal',
      'header' => 'Confeccion grupo conviviente',
      'content' => $this->renderPartial('new', array('model'=>$findPersonaForm), true),
      'onHidden' => 'js:function(){resetModal()}',
      'onShow' => 'js:function(){resetAdvice()}'
   )); 
   $domicilioCompleto = $solicitud->domicilio->calle . " " . $solicitud->domicilio->altura;
?>

<div class="row">
   <legend class="span10">
      <div class="row">
         <div class="span8"><?php echo "Detalles de la vivienda en domicilio $domicilioCompleto" ?></div>
         <div class="span1">
            <?php echo TbHtml::labelTb("$titular->nombre $titular->apellido", array('color' => TbHtml::LABEL_COLOR_INFO)); ?>
         </div>
      </div>
   </legend>
</div>

<div class="row">
   <div class="span8 offset2">
      <h4>Detalle servicios</h4>
   </div>
</div>
<div class="row">
   <div class="span6 offset2">
      <table class="table table-striped" id="servicios-table">
         <thead>
            <tr>
               <th>Servicio</th>
               <th><?php echo TbHtml::tooltip("Disponible", "#", "Marcar los servicios que estan disponibles en el domicilio")?></th>
               <th><?php echo TbHtml::tooltip("Posee medidor", "#", "Solo indicar si se sabe con veracidad que el servicio dispone de un medidor")?></th>
               <th><?php echo TbHtml::tooltip("Es compartido", "#", "En el caso que pague en forma conjunta con otros vecinos")?></th>
            </tr>
         </thead>
         <tbody>
            <?php
            $servicios = $confeccionGrupoConvivienteForm->servicios;
            foreach ($this->getServicios() as $key => $value) {
               $tipoServicioId = array();
               foreach ($servicios as $servicio) {
                  array_push($tipoServicioId, $servicio['tipo_servicio_id']);
               }

               $index = array_search($key, $tipoServicioId);
               $disponible = is_integer($index) ? true : false;
               $medidor = is_integer($index) ? $servicios[$index]['medidor'] : false;
               $compartido = is_integer($index) ? $servicios[$index]['compartido'] : false;
               echo "<tr>";
                  echo CHtml::tag('td', array(), $value);
                  echo CHtml::tag('td', array('class' =>'servicio-disponible', 'servicio-id'=>"$key"), TbHtml::checkBox('', $disponible));
                  echo CHtml::tag('td', array('class' =>'servicio-medidor'), TbHtml::checkBox('', $medidor));
                  echo CHtml::tag('td', array('class' =>'servicio-compartido'), TbHtml::checkBox('', $compartido));
               echo "</tr>";
            }?>
         </tbody>
      </table>
   </div>
</div>

<div class="row">&nbsp;</div>

<div class="row">
   <div class="span6 offset2">
      <h4>Detalles sanitarios</h4>
   </div>
</div>

<div class="row">
   <div class="span7 offset2">
      <div class="well">
         <div id="banios-container">
            <?php
               foreach ($confeccionGrupoConvivienteForm->banios as $key => $value):?>
                  <div class="row banio-row">
                     <div class="span2">
                        <?php echo TbHtml::dropDownList('interno','', array('Externo', 'Interno'),
                              array('class'=>'span2', 'options'=>array($value['interno'] => array('selected'=>true))));?>
                     </div>
                     <div class="span2">
                        <?php echo TbHtml::dropDownList('completo','', array('Incompleto', 'Completo'),
                              array('class'=>'span2', 'options'=>array($value['completo'] => array('selected'=>true))));?>
                     </div>
                     <div class="span2">
                     <?php echo TbHtml::checkBox('es_letrina', $value['es_letrina'], array('class'=>'span1', 'label'=>'Letrina', 'style'=>''));?>
                     </div>
                        
                     <?php echo $key ? '<span class="icon-remove"></span>': "";?>
                  </div>
            <?php endforeach?>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="span2 offset7">
      <?php echo TbHtml::button('Agregar ba&ntilde;o', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'id'=>'add-banio-btn',
            'size' => TbHtml::BUTTON_SIZE_MINI)
         );
      ?>
   </div>
</div>

<div class="row">
   <div class="span8 offset2">
      <h4>Observaciones generales</h4>
   </div>
</div>
<div class="row">
   <div class="span6 offset2">
      <textarea cols="30" rows="10" id="vivienda-actual-textarea" style="width: 100%">
         <?php echo $confeccionGrupoConvivienteForm->observaciones ?>
      </textarea>
   </div>
</div>

<div class="row">&nbsp;</div>

<div class="row">
   <div class="span10">
      <legend><?php echo "Grupo conviviente en domicilio $domicilioCompleto" ?></legend>
   </div>
</div>

<div class="row">
   <div class="span10">
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
            <tr class="success">
               <td><?php echo "$titular->nombre"?></td>
               <td><?php echo "$titular->apellido"?></td>
               <td class="dni"><?php echo "$titular->dni"?></td>
               <td><?php echo ""?></td>
               <td><?php echo "Si"?></td>
               <td><?php echo "Titular"?></td>
               <td><?php echo  ""?></td>
            </tr>
            <?php
               foreach ($confeccionGrupoConvivienteForm->convivientes as $key => $value) {
                  if($value['sexo'] == 'M') {
                     $vinculos = TbHtml::dropDownList('vinculo', '', $vinculosMasculinosList, array('class'=>'vinculos-masculinos-combo', 'options'=>array($value['vinculo'] => array('selected'=>true))));
                  } else {
                     $vinculos = TbHtml::dropDownList('vinculo', '', $vinculosFemeninosList, array('class'=>'vinculos-femeninos-combo', 'options'=>array($value['vinculo'] => array('selected'=>true))));

                  }
                  echo "<tr>";
                     echo CHtml::tag('td', array(), $value['nombre']);
                     echo CHtml::tag('td', array(), $value['apellido']);
                     echo CHtml::tag('td', array('class' => 'dni'), $value['dni']);
                     echo CHtml::tag('td', array(), $vinculos);
                     if($value['solicitante_foraneo']) {
                        echo CHtml::tag('td', array(), TbHtml::tooltip('No aplica', '#', "Figura como solicitante en otra solicitud. No puede ser solicitante aqui."));
                        echo CHtml::tag('td', array(), TbHtml::tooltip('No aplica', '#',"Figura como solicitante en otra solicitud. No puede ser cotitular."));
                        echo CHtml::tag('td', array(), TbHtml::tooltip('', '#',"Figura como solicitante en otra solicitud. No puede ser removida del grupo.", array('class'=>'icon-lock')));
                     } else {
                        echo CHtml::tag('td', array(), TbHtml::checkBox('', $value['solicitante']));
                        echo CHtml::tag('td', array(), TbHtml::radioButton('cotitular', $value['cotitular']));
                        echo CHtml::tag('td', array(), TbHtml::tag('span', array('class'=>'icon-remove')));
                     }
                  echo "</tr>";
               }
             ?>
         </tbody>
      </table>
   </div>
</div>
<div class="row">
   <div class="span2">
      <?php echo TbHtml::button('Agregar persona', array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'id'=>'add-persona-btn',
         'data-toggle' => 'modal',
         'data-target' => '#convivienteModal',)
      );?>
         
   </div>
</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>
<div class="row">&nbsp;</div>

<div class="row">
   <div class="offset6 span2">
      <?php echo TbHtml::button('Guardar en borrador', array('id'=>'submit-borrador-btn'));?>
   </div>
   <div class="span2">
      <?php echo TbHtml::button('Guardar y activar', array('id'=>'submit-activar-btn', 'color' => TbHtml::BUTTON_COLOR_SUCCESS));?>
   </div>
   
</div>



<script type="text/javascript">
   //some wide used vars
   var addedDnis = []
   var findPersonaForm = jQuery('#convivienteModal form').clone();
   var vinculosMasculinosCombo = jQuery('.vinculos-masculinos-combo.hide');
   var vinculosFemeninosCombo = jQuery('.vinculos-femeninos-combo.hide');
   var detalleBanio = jQuery(jQuery('.banio-row').get(0)).clone();

   //init 
   jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
   jQuery('#convivienteModal form button').click(onFindPersonaClick);
   jQuery('td.servicio-disponible').click(onClickServicioDisponible);
   jQuery('#add-banio-btn').click(onAddDetalleBanio);
   jQuery('#submit-borrador-btn').click(function(){onSubmit('Borrador')});
   jQuery('#submit-activar-btn').click(function(){onSubmit('Activa')});

   jQuery('#banios-container .icon-remove').click(function(){
      jQuery(this).parents('.banio-row').remove();
   });

   jQuery('#grupo-conviviente .icon-remove').click(function(){
      removeDni($(this).parent().siblings(".dni").text())
      $(this).parents('tr').remove()
    })
   jQuery("#grupo-conviviente .dni").each(function(){
      addedDnis.push(jQuery(this).text())
   })


   //Callbacks
   function onFindPersonaClick() {
      if(isPresent(jQuery('#convivienteModal form').find('input#SolicitudFindUserForm_dni').val()))  {
         jQuery('#advice-container').attr('class', 'alert alert-error').text("El DNI ya existe en la lista")
         jQuery('#convivienteModal').modal('hide');
         return;
      }

      $.post('/Solicitud/_getconviviente?use=s:<?php echo $solicitud->id?>', jQuery('#convivienteModal form').serialize())
         .done(findPersonaSuccessCallback)
         .fail(findPersonaErrorCallback);
   }

   function findPersonaSuccessCallback(data, status, jqXHR ) {
      if(jqXHR.getResponseHeader('Content-Type') == 'application/json') {
         addConvivienteSuccessCallback(data);
      } else {
         jQuery('#convivienteModal .modal-body').empty().append(data);
         jQuery('#convivienteModal form').submit(function(e){e.preventDefault();});
         jQuery('#convivienteModal form button').click(onAddConvivienteButton);
         jQuery('#convivienteModal form a.btn').remove()
      }
   }

   function findPersonaErrorCallback(data) {
      jQuery('#convivienteModal .modal-body').empty().append(data.responseText);
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
         jQuery(this).parents('.banio-row').remove();
      })
      var detalle = detalleBanio.clone();
      detalle.append(removeButton)
      jQuery('#banios-container').append(detalle)

   }

   function onSubmit(estado) {
      var values = []
      values.push({name: 'ConfeccionGrupoConvivienteForm[estado]', value: estado})

      //servicios
      var arrayIndex = 0
      jQuery('#servicios-table tbody tr').each(function(i,e) {
         if(jQuery(e).find('td.servicio-disponible input').prop('checked')) {
            var baseName = 'ConfeccionGrupoConvivienteForm[servicios][' + (arrayIndex++) + ']'
            var id = jQuery(e).find('td.servicio-disponible').attr('servicio-id')
            var medidor = jQuery(e).find('td.servicio-medidor input').prop('checked') ? 1 : 0;
            var compartido = jQuery(e).find('td.servicio-compartido input').prop('checked') ? 1 : 0;
            values.push({name: baseName + '[tipo_servicio_id]', value: id})
            values.push({name: baseName + '[medidor]', value: medidor})
            values.push({name: baseName + '[compartido]', value: compartido})
         }
      });

      //banios
      jQuery('#banios-container .banio-row').each(function(i,e) {
         var interno = jQuery(e).find('select#interno').val()
         var completo = jQuery(e).find('select#completo').val()
         var letrina = jQuery(e).find(':checkbox').prop('checked') ? 1 : 0;

         var baseName = 'ConfeccionGrupoConvivienteForm[banios][' + i + ']'
         values.push({name: baseName + '[interno]', value: interno})
         values.push({name: baseName + '[completo]', value: completo})
         values.push({name: baseName + '[es_letrina]', value: letrina})

      });
      
      values.push({name: 'ConfeccionGrupoConvivienteForm[observaciones]', value: jQuery('#vivienda-actual-textarea').val()})

      //convivientes
      jQuery('#grupo-conviviente tbody tr').each(function(i, trEl) {
         if(i > 0) {
            var baseName = 'ConfeccionGrupoConvivienteForm[convivientes][' + (i-1) + ']'
            var dni = jQuery(trEl).find('td.dni').text();
            var vinculo = jQuery(trEl).find("select").val();
            var solicitante = jQuery(trEl).find(":checkbox").prop('checked') ? 1 : 0;
            var cotitular = jQuery(trEl).find(":radio").prop('checked') ? 1 : 0;

            values.push({name: baseName + '[dni]', value: dni})
            values.push({name: baseName + '[vinculo]', value: vinculo})
            values.push({name: baseName + '[solicitante]', value: solicitante})
            values.push({name: baseName + '[cotitular]', value: cotitular})
               
         }
      });

      submit(values);
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
      action: <?php echo "'$confeccionGrupoConvivienteForm->action?use=s:$solicitud->id'" ?>,
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


   //Triggering events for dynamic content
   jQuery('td.servicio-disponible').trigger('click')
</script>

<?php //hack FF por el datepicker + modal - Solo implemente una parte, que es, volar la funcion de 'enforce'
// http://jsfiddle.net/surjithctly/93eTU/16/
//http://stackoverflow.com/questions/21059598/implementing-jquery-datepicker-in-bootstrap-modal
Yii::app()->clientScript->registerScript('script', <<<JS
   jQuery.fn.modal.Constructor.prototype.enforceFocus = function(){};
JS
, CClientScript::POS_READY);?>