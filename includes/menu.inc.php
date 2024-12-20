<?php

class Menu {
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
        $menu = '<div class="container">
                    <div class="menu-bg-wrap">
                        <div class="site-navigation">
                            <a href="index.html" class="logo m-0 float-start"><i class="fa-solid fa-ship"></i> Balatoni hajók</a>
                            <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end">';

        foreach(self::$menu as $menuindex => $menuitem) {
            if ($menuitem[1] == "") {
                $submenu = self::generateSubMenu($menuindex);
                if ($submenu != "") {
                    $menu .= '<li class="has-children"><a class="icon-link" href="'.SITE_ROOT.$menuindex.'">'.$menuitem[0].'</a>';
                    $menu .= '<ul class="dropdown">'.$submenu.'</ul></li>';
                } else {
                    $menu .= '<li><a href="'.SITE_ROOT.$menuindex.'">'.$menuitem[0].'</a></li>';
                }
            }
        }

        $menu .= '</ul>
                    <a href="#" class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none">
                        <span></span>
                    </a>
                </div>
              </div>
            </div>';

        return $menu;
    }

    private static function generateSubMenu($parent) {
        $submenu = "";
        foreach (self::$menu as $menuindex => $menuitem) {
            if ($menuitem[1] == $parent) {
                $submenu .= '<li><a href="'.SITE_ROOT.$menuindex.'">'.$menuitem[0].'</a></li>';
            }
        }
        return $submenu;
    }
}

Menu::setMenu();
