<?php
/*
 * Database-ready model layer.
 * For now the project uses sample arrays and a 30-minute browser cookie for the demo user.
 * Later, replace these methods with database queries without changing the views.
 */
class AppData {
    public static function lostItems() {
        return [
            ['id'=>1,'name'=>'Blue Backpack','location'=>'Central Park','date'=>'2024-01-15','description'=>'Navy blue backpack with laptop compartment'],
            ['id'=>2,'name'=>'Gold Watch','location'=>'Downtown Mall','date'=>'2024-01-14','description'=>'Vintage gold watch with leather strap'],
            ['id'=>3,'name'=>'iPhone 13','location'=>'City Library','date'=>'2024-01-13','description'=>'Black iPhone 13 with clear case'],
        ];
    }

    public static function foundItems() {
        return [
            ['id'=>4,'name'=>'iPhone 13 Pro','location'=>'Central Station Platform 3','date'=>'2024-01-20','description'=>'Space gray iPhone with clear case, locked screen','status'=>'Unclaimed'],
            ['id'=>5,'name'=>'Montblanc Pen','location'=>'Conference Center Room 204','date'=>'2024-01-20','description'=>'Black fountain pen with gold trim','status'=>'Pending'],
            ['id'=>6,'name'=>'Adidas Gym Bag','location'=>'Fitness First Locker Room','date'=>'2024-01-19','description'=>'Black Adidas duffel with red stripes','status'=>'Unclaimed'],
        ];
    }

    public static function reportedItems() {
        return [
            ['name'=>'MacBook Pro','location'=>'Central Library','date'=>'2024-01-20','type'=>'Lost','status'=>'Active'],
            ['name'=>'AirPods Pro','location'=>'University Campus','date'=>'2024-01-18','type'=>'Lost','status'=>'Found'],
            ['name'=>'Nike Backpack','location'=>'City Gym','date'=>'2024-01-15','type'=>'Found','status'=>'Active'],
        ];
    }

    public static function getUser() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!empty($_SESSION['user'])) return $_SESSION['user'];
        if (!empty($_COOKIE['kk_user'])) {
            $data = json_decode($_COOKIE['kk_user'], true);
            if (is_array($data) && !empty($data['email'])) return $data;
        }
        return null;
    }

    public static function saveUser($user) {
        $payload = json_encode($user);
        setcookie('kk_user', $payload, [
            'expires' => time() + 1800,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION['user'] = $user;
    }

    public static function clearLoginOnly() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        unset($_SESSION['user'], $_SESSION['isLoggedIn']);
        // Important: kk_user is NOT deleted. The registered account stays available for 30 minutes.
    }
}
