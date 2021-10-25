<?php

class SalesList
{
    // raw array of salespeople.
    public $sales_people =
        [
            ['name', 'phone', 'Lifetime Sales', 'YTD Sales'],
            ['alex', '111-111-1111', '10000', '1200'],
            ['casey', '222-222-2222', '25000', '1100'],
            ['steve', '333-333-3333', '15000', '1500']
        ];

    // array for the formatted list of salespeople.
    public $display_list;

    public function __construct()
    {
        // grab column names for use as keys in $display_list
        $columns = array_shift($this->sales_people);

        // build $display_list
        foreach ($this->sales_people as $person) {
            $person = array_combine($columns, $person);
            $person['name'] = $this->capitalizeName($person['name']);
            $person['phone'] = $this->formatPhone($person['phone']);
            $this->display_list[] = $person;
        }

    }

    private function capitalizeName($name)
    {
        return ucfirst($name);
    }

    private function formatPhone($phone)
    {
        // see: https://stackoverflow.com/questions/4708248/formatting-phone-numbers-in-php/4708314
        return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone);
    }

    public function displayList()
    {
        $list = "<ol>";
        //get max values of both sales figures.
        $year_to_date = max(array_column($this->display_list, 'YTD Sales'));
        $lifetime = max(array_column($this->display_list, 'Lifetime Sales'));
        // build ordered list and assign sales awards
        foreach ($this->display_list as $person) {
            $list .= "<li> Call " . $person['name'] . " at " . $person['phone'];
            if ($person['YTD Sales'] == $year_to_date) {
                $list .= "-- Highest YTD Sales --";
            }
            if ($person['Lifetime Sales'] == $lifetime) {
                $list .= "-- Highest Lifetime Sales --";
            }
        }
        $list .= "</ol>";
        return $list;
    }

}

$list = new SalesList();
echo $list->displayList();