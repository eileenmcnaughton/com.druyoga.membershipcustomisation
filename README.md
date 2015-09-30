A lightweight module to select the hidden is_recur form field depending on the options.

It is not currently possible in CiviCRM core to have a price field with 2 separate options
for the same membership type with one being always recurring & the other being not recurring
(ie pay monthly OR pay for the full year).

However, IF the membership type can be is set to have renewal as being optional then there would normally be
a checkbox for the user. This extension simply hides & ticks that checkbox.

Warning: since writing this I've noticed that if you are switching between payment processors on the form or
a payment processor & pay later there is core js that messes with the same checkbox so if you are using that config then
test.

Note this extension is currently hard-coded with the expectation that the options at the top of
membershipcustomisation.php will be altered (very occasionally).

Note the membership type MUST be configured for optional renewal.
