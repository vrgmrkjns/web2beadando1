<?php

Class Menu {
    public static $menu = array();

    public static function setMenu() {
        self::$menu = array();
        $connection = Database::getConnection();
        $stmt = $connection->query("SELECT url, nev, szulo, jogosultsag FROM menu WHERE jogosultsag LIKE '".$_SESSION['userlevel']."' ORDER BY sorrend");
        while($menuitem = $stmt->fetch(PDO::FETCH_ASSOC)) {
            self::$menu[$menuitem['url']] = array($menuitem['nev'], $menuitem['szulo'], $menuitem['jogosultsag']);
        }
    }

    public static function getMenu($sItems) {
        $submenu = "";
        
        $menu = '   <div class="container">
                        <div class="menu-bg-wrap">
                            <div class="site-navigation">
                                <i class="fa-solid fa-ship"></i>
                                <a href="index.html" class="logo m-0 float-start">Balatoni hajók</a>
                                <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end">';

        foreach(self::$menu as $menuindex => $menuitem) {
            if($menuitem[1] == "") {
                $menu .= '<li><a href="'.SITE_ROOT.$menuindex.'" '.($menuindex==$sItems[0] ? "class='selected'" : "").'>'.$menuitem[0].'</a></li>';
            } else if($menuitem[1] == $sItems[0]) {
                $submenu .= '<li><a href="'.SITE_ROOT.$sItems[0].'/'.$menuindex.'" '.($menuindex==$sItems[1] ? "class='selected'" : "").'>'.$menuitem[0].'</a></li>';
            }
        }

        $menu .= '</ul>';

        if ($submenu != "") {
            $menu .= '<ul class="dropdown">'.$submenu.'</ul>';
        }

        $menu .= '<a href="#" class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none">
                      <span></span>
                  </a>
                </div>
              </div>
            </div>';

        return $menu;
    }
}

Menu::setMenu();
