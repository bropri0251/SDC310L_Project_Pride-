<?php
// Basic product catalog (text only)
function GetProducts()
{
    return array(
        1 => array(
            "id" => 1,
            "name" => "Gaming Mouse",
            "description" => "Wireless mouse with adjustable DPI and ergonomic grip.",
            "cost" => 49.99
        ),
        2 => array(
            "id" => 2,
            "name" => "Mechanical Keyboard",
            "description" => "RGB keyboard with tactile switches and durable keycaps.",
            "cost" => 89.99
        ),
        3 => array(
            "id" => 3,
            "name" => "Gaming Headset",
            "description" => "Comfort fit headset with surround sound and noise isolation.",
            "cost" => 79.99
        ),
        4 => array(
            "id" => 4,
            "name" => "Mouse Pad (Extended)",
            "description" => "Large extended pad for smooth tracking and stable keyboard placement.",
            "cost" => 19.99
        ),
        5 => array(
            "id" => 5,
            "name" => "USB-C Cable",
            "description" => "Braided USB-C cable for charging and data transfer (6ft).",
            "cost" => 12.50
        )
    );
}
?>
