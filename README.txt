=== Booking Calendar Contact Form ===
Contributors: codepeople
Donate link: http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form
Tags: contact form,booking form,reservation form,calendar,form,payment form,paypal form,booking calendar,reservation calendar,calendar form,booking
Requires at least: 3.0.5
Tested up to: 3.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Booking Calendar Contact Form creates a booking form with a reservation calendar or a classic contact form, connected to a PayPal payment button.

== Description ==

Booking Calendar Form main features:

	» Booking form connected to PayPal
	» Optional availability verification
	» Season management
	» full-day bookings or partial-day bookings as used in hotels
	» Built-in captcha anti-spam
	» Configurable email texts
	» Configurable validation messages
	» Printable bookings list
	» ... and more features (see below)

With the **Booking Calendar Contact Form** you can create a **classic contact form** or a **booking form with a reservation calendar**, connected to a PayPal payment button. The reservation calendar lets the customer select the start (ex: check-in) and end (ex: checkout) dates.

The **reservation calendar** is an optional item, so it can be disabled to create a **general purpose contact form**.

There are two types of bookings available in the calendar configuration: full day bookings or partial day bookings. With full day bookings the whole day is blocked / reserved while in partial day bookings the start and end dates are partially blocked as used for example in **room/hotel bookings**.

Features:

* **Booking form** connected to PayPal: After clicking the reservation / book button on the booking form, the user is redirected to PayPal and after completing the payment three emails will be sent: the automatic PayPal notification, the booking confirmation email to the user sent from the website and the notification email to the website administrator containing the booking details. At this point the booking will be confirmed and will appear in the bookings list and calendar. 
* **Reservation / booking calendar** with optional availability verification: The dates are blocked in the calendar only if the "bookings overlap" option is enabled (it's enabled by default).
* **Season management:** Configuration accepts different prices for different dates (ex: low / medium / high season prices, special date's prices, etc...)
* Supports **full-day bookings** or **partial day bookings** as used in hotels / room reservations (details mentioned above)
* Allows to disable/hide the booking calendar to convert the booking form in a **general purpose contact form**

Other features also present in this version:

* Built-in captcha anti-spam protection on the booking form
* Easy visual selection of the start and end dates
* Configurable email texts
* Configurable validation messages
* Lets to assign a user to the calendar, this way a user with editor access will access his/her own booking calendar
* List of bookings with print option
* Several configurable fields, settings and behaviors (date format, min/max dates, block dates, etc...)

What isn't included in the free version described here?

* The Form Builder for customizing the form is present only in the pro version. The free version works with the classic predefined form included on it.
* The connection to PayPal is part of the booking process in the free version, so it cannot be disabled on it. The pro version has additional code to work with or without the PayPal connection.
* Coupons/discount codes and other minor features are present only in the pro version. 

For information about the pro version check the plugin's page: http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form


== Installation ==

To install **Booking Calendar Contact Form**, follow these steps:

1.	Download and unzip the booking plugin
2.	Upload the entire booking-calendar-contact-form/ directory to the /wp-content/plugins/ directory
3.	Activate the Booking Calendar Contact Form plugin through the Plugins menu in WordPress
4.	Configure the booking form settings at the administration menu >> Settings >> Booking Calendar Contact Form. 
5.	To insert the booking form into some content or post use the icon that will appear when editing contents

== Frequently Asked Questions ==

= Q: What means each field in the settings area? =

A: The product's page contains detailed information about each field and customization:

http://wordpress.dwbooster.com/calendars/booking-calendar-contact-form

= Q: Can I customize the booking calendar colors? =

A: This and other questions are already answered in the product's FAQ at this page:

http://wordpress.dwbooster.com/faq/booking-calendar-contact-form

= Q: How to disable the accommodation availability verification? =

A: In the booking calendar administration area, set the field "Accept overlapped reservations?" to "No", this way the accommodation availability verification will be disabled. Note that the calendar will disappear from the admin area when you select this setting since its purpose is to define the available days for booking.

= Q: When is blocked the reservation and sent the email with the rental information? =

A: After clicking the submit / book button the customer is redirected to a PayPal payment page to submit the payment to confirm it. After completed the payment the reservation is saved into the database and calendar, the dates become un-available it the booking availability verification is enabled and the emails are sent with the booking information and the information entered by the customer on the booking form. At that point the booking information will appear also in the printable bookings list.

= Q: Got this error message at PayPal after clicking the book button: "We cannot process this transaction...". Solution?

A: Into the Booking Calendar Contact Form settings >> PayPal payment form configuration >> PayPal email, be sure to put your own PayPal email address instead the email placeholder put there as default. 

= Q: How to translate the plugin texts? =

A: If you don't want to edit the MO/PO files then just edit the texts that are at the beginning of the file "dex_scheduler.inc.php" (the booking page). The booking form validation texts can be edited from the administration area.

= Q: Can I restrict the number of days to book? =

A: This feature is available in the pro version.


== Screenshots ==

1. Booking Calendar form / contact form.
2. Inserting booking calendar into a page.
3. Managing the booking calendar.
4. Editing the calendar and rental settings.
5. Booking Calendar settings.

== Changelog ==

= 1.0 =
* First stable version released.
* More configuration options added.

== Upgrade Notice ==

= 1.0.1 =
* Interface modifications.