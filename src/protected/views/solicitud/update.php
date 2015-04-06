<?php 

if(Yii::app()->user->hasFlash('generalError')){
   echo TbHtml::alert(TbHtml::ALERT_COLOR_ERROR, Yii::app()->user->getFlash('generalError'));
}

$this->widget('bootstrap.widgets.TbTabs',
               array('tabs' => array(
                     array('label' => 'Informacion Basica',
                           'content' => $this->renderPartial('solicitudBase', array('model'=>$baseForm), true),
                           'active' => true
                           ),
                     array('label' => 'Grupo Conviviente y detalles de la vivienda',
                           'content' => $this->renderPartial('confeccionGrupoConviviente', array(
                                                                                    'findPersonaForm' => $findPersonaForm,
                                                                                    'confeccionGrupoConvivienteForm' => $confeccionGrupoConvivienteForm,
                                                                                    'vinculosFemeninosList' => $vinculosFemeninosList,
                                                                                    'vinculosMasculinosList' => $vinculosMasculinosList,
                                                                                    'solicitud' => $solicitud), true),
                           ),
                     )
               )
);

?>