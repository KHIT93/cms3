<div class="page-head">
    <h2><?php print t('Modules'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<div class="col-md-12">
<?php
print '<p>'.t('Download additional modules from other developers in order to extend the functionality of the system').'</p>'
    . '<p>'.t('Review and install updates for enabled modules').'</p>';
$output = '<form name="modules" method="POST" action="" role="form">'
        . '<table class="table">'
        . '<thead style="background-color: #CCC;">'
        . '<tr>'
        . '<th class="col-md-1"><strong>'.t('Enabled').'</strong></th>'
        . '<th class="col-md-1"><strong>'.t('Name').'</strong></th>'
        . '<th class="col-md-1"><strong>'.t('Version').'</strong></th>'
        . '<th class="col-md-6"><strong>'.t('Description').'</strong></th>'
        . '<th class="col-md-3"><strong>'.t('Actions').'</strong></th>'
        . '</tr>'
        . '</thead>'
        . '<tbody class="no-border-y">';
foreach (Module::allModules() as $module) {
    $link = array();
    $attr = '';
    $output .= '<tr>';
    if($module['enabled'] === true) {
        $attr = 'checked';
        //$link['conf']['link'] = ($module['core_module'] == 1) ? 'config/core' : 'config';
        $link['conf']['link'] = (isset($module['config'])) ? $module['config'] : 'admin/modules/'.$module['module'].'/config';
        $link['conf']['text'] = t('Configure');
        $link['conf']['classes'] = 'btn btn-rad btn-sm btn-primary';
        $link['action']['link'] = ($module['core'] == 1) ? 'uninstall/core' : 'uninstall';
        $link['action']['text'] = t('Uninstall');
        $link['action']['classes'] = 'btn btn-rad btn-sm btn-danger';
        /*if(isset($module['cancontrol']) && $module['cancontrol'] == 0) {
            $attr .= ' ';
            $attr .= 'disabled';
        }*/
    }
    else {
        if($module['installed'] === true) {
            $link['conf']['link'] = ($module['core'] == 1) ? 'admin/modules/'.$module['module'].'/enable/core' : 'admin/modules/'.$module['module'].'/enable';
            $link['conf']['text'] = t('Enable');
            $link['conf']['classes'] = 'btn btn-rad btn-sm btn-default';
            $link['action']['link'] = ($module['core'] == 1) ? 'uninstall/core' : 'uninstall';
            $link['action']['text'] = t('Uninstall');
            $link['action']['classes'] = 'btn btn-rad btn-sm btn-danger';
            /*if(isset($module['cancontrol']) && $module['cancontrol'] == 0) {
                $attr .= 'disabled';
            }*/
        }
        else {
            $link['action']['link'] = ($module['core'] == 1) ? 'install/core' : 'install';
            $link['action']['text'] = t('Install');
            $link['action']['classes'] = 'btn btn-rad btn-sm btn-success';
            /*if(isset($module['cancontrol']) && $module['cancontrol'] == 0) {
                $attr .= 'disabled';
            }*/
        }
    }
    $actions = (isset($link['conf'])) ?'<a href="'.'/'.$link['conf']['link'].'" class="'.$link['conf']['classes'].'">'.$link['conf']['text'].'</a>'
            . '<a href="/admin/modules/'.$module['module'].'/'.$link['action']['link'].'" class="'.$link['action']['classes'].'">'.$link['action']['text'].'</a>'
            : '<a href="/admin/modules/'.$module['module'].'/'.$link['action']['link'].'" class="'.$link['action']['classes'].'">'.$link['action']['text'].'</a>' ;
    $output .= '<td><input type="checkbox" class="icheck" name="module-'.$module['module'].'" '.$attr.'></td>'
            . '<input type="hidden" name="moduleType" value="'.$module['core'].'">';
    $output .= '<td><label for="module-'.$module['module'].'"><strong>'.$module['name'].'</strong></label></td>'
            . '<td>'.$module['version'].'</td>'
            . '<td>'.$module['description'].'</td>';
    $output .= '<td>'
            . $actions
            . '</td>'
            . '</tr>';
}
$output .= '</tbody>'
        . '</table>'
        . '</form>';
print $output;
?>
</div>