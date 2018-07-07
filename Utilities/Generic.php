<?php
/*
 * Author:      Jacob Mills
 * Date:        06/29/2018
 * Description: This utility provides static functions to implement helpful generic Utilities
 *
 */

class Generic
{
    // Follows exponetional model for discrete rankings 1-22
    // on an interval between 1 and 1000.
    // rank^(2.26) = reputation,   or
    // log2.26(reputation) = rank
    public static function getRankIcon($points) {
			if ($points >= 1000)
				$icon = "/images/icons/5stargeneral.png";
			else if ($points >= 871)
				$icon = "/images/icons/general.png";
			else if ($points >= 776)
				$icon = "/images/icons/lieutenantgeneral.png";
			else if ($points >= 687)
				$icon = "/images/icons/majorgeneral.png";
			else if ($points >= 604)
				$icon = "/images/icons/brigadiergeneral.png";
			else if ($points >= 526)
				$icon = "/images/icons/colonel.png";
			else if ($points >= 455)
				$icon = "/images/icons/lieutenantcolonel.png";
			else if ($points >= 390)
				$icon = "/images/icons/major.png";
			else if ($points >= 330)
				$icon = "/images/icons/captain.png";
			else if ($points >= 275)
				$icon = "/images/icons/firstlieutenant.png";
			else if ($points >= 226)
				$icon = "/images/icons/secondlieutenant.png";
			else if ($points >= 182)
				$icon = "/images/icons/commandsergeantmajor.png";
			else if ($points >= 143)
				$icon = "/images/icons/sergeantmajor.png";
			else if ($points >= 110)
				$icon = "/images/icons/firstsergeant.png";
			else if ($points >= 81)
				$icon = "/images/icons/mastersergeant.png";
			else if ($points >= 57)
				$icon = "/images/icons/sergeantfirstclass.png";
			else if ($points >= 38)
				$icon = "/images/icons/staffsergeant.png";
			else if ($points >= 23)
				$icon = "/images/icons/sergeant.png";
			else if ($points >= 12)
				$icon = "/images/icons/corporal.png";
			else if ($points >= 5)
			  $icon = "/images/icons/privateFirstClass.png";
			else
				$icon += "/images/icons/private.png";

		  return $icon;
    }
}
