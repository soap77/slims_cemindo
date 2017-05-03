<?php
/**
 *
 * Copyright (C) 2010 Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/* Staff Activity by Day */
/* modified 2017 by heru subekti (heroe.soebekti@gmail.com) */

// key to authenticate
define('INDEX_AUTH', '1');

// main system configuration
require '../../../../sysconfig.inc.php';
// IP based access limitation
require LIB.'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-reporting');
// start the session
require SB.'admin/default/session.inc.php';
require SB.'admin/default/session_check.inc.php';
// privileges checking
$can_read = utility::havePrivilege('reporting', 'r');
$can_write = utility::havePrivilege('reporting', 'w');

if (!$can_read) {
    die('<div class="errorBox">'.__('You don\'t have enough privileges to access this area!').'</div>');
}

require SIMBIO.'simbio_GUI/form_maker/simbio_form_element.inc.php';
require SIMBIO.'simbio_UTILS/simbio_date.inc.php';

// months array
$months['01'] = __('Jan');
$months['02'] = __('Feb');
$months['03'] = __('Mar');
$months['04'] = __('Apr');
$months['05'] = __('May');
$months['06'] = __('Jun');
$months['07'] = __('Jul');
$months['08'] = __('Aug');
$months['09'] = __('Sep');
$months['10'] = __('Oct');
$months['11'] = __('Nov');
$months['12'] = __('Dec');

$page_title = 'Staff Activity by Day';

$reportView = false;
if (isset($_GET['reportView'])) {
    $reportView = true;
}

if (!$reportView) {
?>
    <!-- filter -->
    <fieldset style="margin-bottom: 3px;">
	  <div class="per_title">
	    <h2><?php echo __('Staff Activity'); ?></h2>
    </div>
    <div class="infoBox">
    <?php echo __('Report Filter'); ?>
    </div>
	  <div class="sub_section">
        <div class="btn-group">
            <a href="<?php echo MWB; ?>reporting/xlsoutput.php" class="btn btn-primary" target="_blank"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;<?php echo __('Export to spreadsheet format'); ?></a>
        </div>
    <form id="a" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="reportView">
    <div id="filterForm">
        <div class="divRow">
            <div class="divRowLabel"><?php echo __('Real Name'); ?></div>
            <div class="divRowContent">
            <?php
            $status_q = $dbs->query('SELECT user_id, realname FROM user');
            $staff_options = array();
            $staff_options[] = array('0', __('ALL'));
            while ($status_d = $status_q->fetch_row()) {
                $staff_options[] = array($status_d[1], $status_d[1]);
            }
            echo simbio_form_element::selectList('staff', $staff_options);
            ?>
            </div>

            <div class="divRowLabel"><?php echo __('Activity'); ?></div>
            <div class="divRowContent">
            <?php
            $activity_options = array();
            $activity_options[] = array('', __('ALL'));
            $activity_options[] = array('1', __('Bibliography Data Entry'));
            $activity_options[] = array('2', __('Item Data Entry'));
            $activity_options[] = array('3', __('Member Data Entry'));
            $activity_options[] = array('4', __('Circulation Tasks'));
            echo simbio_form_element::selectList('activity', $activity_options);
            ?>
            </div>

            <div class="divRowLabel"><?php echo __('Year'); ?></div>
            <div class="divRowContent">
            <?php
            $current_year = date('Y');
            $year_options = array();
            for ($y = $current_year; $y > 1999; $y--) {
                $year_options[] = array($y, $y);
            }
            echo simbio_form_element::selectList('year', $year_options, $current_year);
            ?>
            </div>
            <div class="divRowLabel"><?php echo __('Month'); ?></div>
            <div class="divRowContent">
            <?php
            $current_month = date('m');
            $month_options = array();
            foreach ($months as $idx => $month) {
                $month_options[] = array($idx, $month);
            }
            echo simbio_form_element::selectList('month', $month_options, $current_month);
            ?>
            </div>
        </div>
    </div>
    <div style="padding-top: 10px; clear: both;">
    <input type="submit" name="applyFilter" value="<?php echo __('Apply Filter'); ?>" />
    <input type="hidden" name="reportView" value="true" />
    </div>
    </form>
    </div>
    </fieldset>
    <!-- filter end -->
    <iframe name="reportView" id="reportView" src="<?php echo $_SERVER['PHP_SELF'].'?reportView=true'; ?>" frameborder="0" style="width: 100%; height: 500px;"></iframe>
<?php
} else {
    ob_start();
    $criteria = 'AND log_msg NOT LIKE \'%update%\'';
    $_user = '';
    $log_data = array();
    // year
    $selected_year = date('Y');
    if (isset($_GET['year']) AND !empty($_GET['year'])) {
        $selected_year = (integer)$_GET['year'];
    }
    // month
    $selected_month = date('m');
    if (isset($_GET['month']) AND !empty($_GET['month'])) {
        $selected_month = $_GET['month'];
    }

//other filter   
    if (isset($_GET['staff']) AND !empty($_GET['staff'])) {
        $_user .= $_GET['staff'];
        $criteria .= 'AND log_msg LIKE \''.$_user.'%\''; 
    }

    if (isset($_GET['activity']) AND !empty($_GET['activity'])) {
        if($_GET['activity']==0){
        $criteria .= '';            
        }
        if($_GET['activity']==1){
        $criteria .= ' AND log_msg LIKE \'%'.$_user.' insert bibliographic data%\'';            
        }
        if($_GET['activity']==2){
        $criteria .= ' AND log_msg LIKE \'%'.$_user.' insert item data%\'';            
        }
        if($_GET['activity']==3){
        $criteria .= ' AND log_msg LIKE \'%'.$_user.' add new member%\'';            
        }
        if($_GET['activity']==4){
        $criteria .= ' AND log_type=\'member\' AND (log_msg LIKE \''.$_user.'%transaction with member%\' OR log_msg LIKE \''.$_user.'%return item%\' OR log_msg LIKE \''.$_user.'%Quick Return%\')';            
        }                        
    }

    $_log_q = $dbs->query("SELECT SUBSTRING(log_date, 9, 2) AS mdate, COUNT(log_id) AS vtotal 
        FROM system_log 
        WHERE log_date LIKE '$selected_year-$selected_month%' AND log_location NOT IN('Login','system') ".$criteria." 
        GROUP BY DATE(log_date)");
            while ($_log_d = $_log_q->fetch_row()) {
                $date = (integer)preg_replace('@^0+@i', '',$_log_d[0]);
                $log_data[$date] = '<div class="data">'.($_log_d[1]?$_log_d[1]:'0').'</div>';
            }
                
    // generate calendar
    $output = simbio_date::generateCalendar($selected_year, $selected_month, $log_data);
    // print out
     $no_act = isset($_GET['activity'])?$_GET['activity']:__('ALL');
     $action = isset($act[$no_act])?$act[$no_act]:__('ALL');
     echo '<div class="printPageInfo">Staff Activity Report '.$_user.' for '.$action.' <strong>'.$months[$selected_month].', '.$selected_year.'</strong> <a class="printReport" onclick="window.print()" href="#">'.__('Print Current Page').'</a></div>'."\n";
     echo $output;

    $content = ob_get_clean();
    // include the page template
    require SB.'/admin/'.$sysconf['admin_template']['dir'].'/printed_page_tpl.php';

    //export to spreadsheet
    $filter = isset($criteria)?$criteria:'';
    $xlsquery = 'SELECT log_date AS \''.__('Date and Time').'\''.
        ', log_msg AS \''.__('Description').'\' FROM system_log WHERE log_date LIKE \''.$selected_year.'-'.$selected_month.'%\' AND log_location NOT IN(\'Login\',\'system\') '.$filter.' ORDER BY log_date ASC';
    unset($_SESSION['xlsquery']);
    $user = isset($_GET['staff'])?$_GET['staff']:'all';
    $_SESSION['xlsquery'] = $xlsquery;
    $_SESSION['tblout'] = str_replace(" ", "_",$user)."_staff_activity";

}
