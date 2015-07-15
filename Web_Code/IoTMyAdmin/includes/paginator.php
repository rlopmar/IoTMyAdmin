<?php

/**
 * Written by Rafael Lopez Martinez in June 2015
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class paginator {
    
    private $_conn;
        private $_limit;
        private $_page;
        private $_query;
        private $_total;
        
    public function __construct( $conn, $query ) {
     
        $this->_conn = $conn;
        $this->_query = $query;

        $rs= $this->_conn->query( $this->_query );
        $this->_total = $rs->num_rows;
     
    }
    
    
    public function getPaginatorQuery( $limit = 10, $page = 1 ) {

        $this->_limit = $limit;
        $this->_page = $page;

        if ($this->_limit == 'all') {
            $query = $this->_query;
        } else {
            $query = $this->_query." LIMIT ".(($this->_page - 1)*$this->_limit).", $this->_limit";
        }

        return $query;
    }
    
    public function createLinks($links, $list_class, $extraGetParams) {
        if ($this->_limit == 'all'){
            return '';
        }
        $last = ceil($this->_total/$this->_limit);

        $start = (($this->_page-$links)>0) ? $this->_page-$links:1;
        $end = (($this->_page + $links)<$last) ? $this->_page + $links:$last;

        $html = '<ul class="'.$list_class.'">';

        $class = ($this->_page == 1) ? "disabled":"";
        if($this->_page == 1){ $html.= '<li class="'.$class.'"><a href="#">&laquo; Previous</a></li>';}
        else {$html.= '<li class="'.$class.'"><a href="?limit='.$this->_limit.'&page='.($this->_page - 1).$extraGetParams.'">&laquo; Previous</a></li>';}

        if($start> 1) {
            $html.= '<li><a href="?limit='.$this->_limit.'&page=1'.$extraGetParams.'">1</a></li>';
            $html.= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $start;$i <= $end;$i++) {
            $class = ($this->_page == $i)?"active" : "";
            $html.= '<li class="'.$class.'"><a href="?limit='.$this->_limit.'&page='.$i.$extraGetParams.'">'.$i.'</a></li>';
        }

        if ($end<$last) {
            $html.= '<li class="disabled"><span>...</span></li>';
            $html.= '<li><a href="?limit='.$this->_limit.'&page='.$last.$extraGetParams.'">'.$last.'</a></li>';
        }

        $class = ($this->_page == $last)?"disabled":"";
        if($this->_page == $last){$html .= '<li class="'.$class.'"><a href="#"> Next &raquo;</a></li>';}
        else {$html .= '<li class="'.$class.'"><a href="?limit='.$this->_limit.'&page='.($this->_page + 1).$extraGetParams.'"> Next &raquo;</a></li>';}

        $html .= '</ul>';

        return $html;
    }
}

