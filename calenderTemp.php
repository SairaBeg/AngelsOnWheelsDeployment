<?php
class Calender {
    private $active_year, $active_month, $active_day;
    private $real_year, $real_month, $real_day;
    private $events = [];

    public function __construct($date = null) {
        date_default_timezone_set('America/New_York');
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
        $this->real_year = date('Y');
        $this->real_month = date('m');
        $this->real_day = date('d');
    }

    public function add_campaign($txt, $date, $days = 1, $color = 'blue', $id) {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color, $id];
    }

    public function add_event($txt, $date, $start, $end, $days = 1, $color = '', $id) {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $start, $end, $days, $color, $id];
    }

    public function get_calender_date(){
        $date[] = [$this->active_year, $this->active_month, $this->active_day];
        return $date;
    }

    public function monthCheck($date){
        $explodedString = explode("-",$date);
        $year = '20'.$explodedString[0];
        $month = $explodedString[1];
        $day = $explodedString[2];
        $currentMonth = $this->active_month;
        $currentYear = $this->active_year;
        if($currentYear == $year && $currentMonth == $month){
            return True;
        }
        else{
            return False;
        }
    }


    public function __toString() {
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar">';
        /*$html .= '<div class="header">';
        $html .= '<div class="month-year">&#x21E6;';
        $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
        $html .= '&#x21E8;</div> ';
        $html .= '</div>';*/
        $html .= '<div class="days">';
        foreach ($days as $day) {
            $html .= '
                <div class="day_name">
                    ' . $day . '
                </div>
            ';
        }
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
            $selected = '';
            if ($i == $this->real_day && $this->active_month == $this->real_month && $this->active_year == $this->real_year) {
                $selected = ' selected';
                //echo date_default_timezone_get();
            }
            $html .= '<div class="day_num' . $selected . '">';
            $html .= '<span>' . $i . '</span>';
            foreach ($this->events as $event) {
                for ($d = 0; $d <= ($event[4]-1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
                        if(strcmp(' green', $event[3])!=1){
                            $html .= '<div class="event' . $event[5] . '">' . $event[2] .'-' . $event[3] . ' <a href=eventEdit.php?id='.$event[6].'>';
                            $html .= $event[0];
                            $html .= '</a></div>
                                    ';
                        }
                        else{
                            $html .= '<div class="event' . $event[3] . '"><a href=campaignEdit.php?id='.$event[4].'>';
                            $html .= $event[0];
                            $html .= '</a></div>
                                    ';
                        }
                    }
                }
            }
            $html .= '</div>';
        }
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}
?>