<?php
include 'header.php';

if(isset($_SESSION['id'])) {
    echo "<head><Title>Main Menu</Title></head>";

        echo "&nbsp&nbsp<form action='inventory.php'>
               <input type='submit' value='Inventory'/>
              </form>";

        echo "&nbsp&nbsp<form action='usersTable.php'>
               <input type='submit' value='See Users'/>
              </form>";

        echo "&nbsp&nbsp<form action='changePassword.php'>
                   <input type='submit' value='Change My Password'/>
                  </form>";

        echo "&nbsp&nbsp<form action='checkout.php'>
                   <input type='submit' value='Check-out'/>
                  </form>";

        echo "&nbsp&nbsp<form action='consumables.php'>
               <input type='submit' value='Consumables'/>
              </form>";

        echo "&nbsp&nbsp<form action='clients.php'>
               <input type='submit' value='See Clients'/>
              </form>";

        echo "&nbsp&nbsp<form action='dailyReports.php'>
               <input type='submit' value='Daily Reports'/>
              </form>";

        echo "&nbsp&nbsp<form action='otherReports.php'>
               <input type='submit' value='Other Reports'/>
              </form>";

        echo "&nbsp&nbsp<form action='repairsUpdatesUpgrades.php'>
               <input type='submit' value='Repairs/Updates/Upgrades'/>
              </form>";

        echo "&nbsp&nbsp<form action='serviceAgreements.php'>
               <input type='submit' value='Service Agreements'/>
              </form>";

    } else {
        header("Location: ./login.php");
    }
?>