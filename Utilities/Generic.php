<?php
/*
 * Author:      Jacob Mills
 * Date:        06/29/2018
 * Description: This utility provides static functions to implement helpful generic Utilities
 *
 */

class Generic
{
    // User ID
    public static function getRankIcon($points) {
			if ($points >= 1000)
				$icon = "/images/icons/5stargeneral.png";
			else if ($points >= 900)
				$icon = "/images/icons/general.png";
			else if ($points >= 800)
				$icon = "/images/icons/lieutenantgeneral.png";
			else if ($points >= 700)
				$icon = "/images/icons/majorgeneral.png";
			else if ($points >= 600)
				$icon = "/images/icons/brigadiergeneral.png";
			else if ($points >= 500)
				$icon = "/images/icons/colonel.png";
			else if ($points >= 400)
				$icon = "/images/icons/lieutenantcolonel.png";
			else if ($points >= 350)
				$icon = "/images/icons/major.png";
			else if ($points >= 300)
				$icon = "/images/icons/captain.png";
			else if ($points >= 250)
				$icon = "/images/icons/firstlieutenant.png";
			else if ($points >= 200)
				$icon = "/images/icons/secondlieutenant.png";
			else if ($points >= 160)
				$icon = "/images/icons/commandsergeantmajor.png";
			else if ($points >= 130)
				$icon = "/images/icons/sergeantmajor.png";
			else if ($points >= 100)
				$icon = "/images/icons/firstsergeant.png";
			else if ($points >= 70)
				$icon = "/images/icons/mastersergeant.png";
			else if ($points >= 50)
				$icon = "/images/icons/sergeantfirstclass.png";
			else if ($points >= 35)
				$icon = "/images/icons/staffsergeant.png";
			else if ($points >= 20)
				$icon = "/images/icons/sergeant.png";
			else if ($points >= 10)
				$icon = "/images/icons/corporal.png";
			else if ($points >= 5)
			  $icon = "/images/icons/privateFirstClass.png";
			else
				$icon += "/images/icons/private.png";

		  return $icon;
    }
}
