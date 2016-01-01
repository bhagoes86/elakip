<?php


namespace App\Repositories;


class Utilities {

    /**
     * @param array $lists
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @return string
     */
    public static function breadcrumbs(array $lists)
    {
        $html = '<ol class="breadcrumb">';

        $i = 1;
        foreach($lists as $item => $attribute) {

            if (isset($attribute['url'])) {
                $url = '<a href="'.$attribute['url'].'">'.$item.'</a>';
            } else {
                $url = $item;
            }

            if($i == 1) {
                $html .= '<li>
                    <i class="fa fa-home"></i>'.
                    $url.
                    '<i class="fa fa-angle-right"></i>
                </li>';
            }
            elseif($i == count($lists))
            {
                $html .= '<li>'.$item.'</li>';
            }
            else
            {
                $html .= '<li>'.
                    $url.
                    '<i class="fa fa-angle-right"></i>
                </li>';
            }

            $i++;
        }

        $html .= '</ol>';

        return $html;
    }

}