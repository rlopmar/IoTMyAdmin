# IoT MyAdmin

IoT MyAdmin is a responsive web app designed to upload data to a MySQL database in a easy way from different devices. It was designed 
specially for Arduino projects, but data can be uploaded from different devices, other web sites or scripts, with a simple 
HTTP request. The code for data upload is in the web and it's automatically generated for each device.

Furthermore, IoT MyAdmin have some tools to represent the uploaded data using different type of charts or maps.

This web app have also some tutorial pages to show you with details how it works. Three Arduino project are also included.
Two of them upload data to the web, one using a WiFi shield and the other one using a Adafruit FONA GSM/GPRS module.

The responsive design allows an easy and friendly navigation using different devices, including computers, mobile phones, tablets, etc.

## Installation

This is a web site, so you need to create or use a web server to access to it. There are a lot of tools for create your own
server using your computer (Apache, Wamp, AppServ, ...) and there are many tutorials about this on the web.<br>
If you don't want to use your computer as a server or you don't know how to do it, using a free web server (like Hostinger for example)
is an easy and quick solution.

The main process has 3 steps:<br>
<ol>
  <li> Create the database importing the "IoTMyAdmin.sql" file from the "Database_SQL" folder. Really easy using PHP MyAdmin for example.</li><br>
  <li> Open the "Web_Code" folder and copy the whole "IoTMyAdmin" folder into your server public folder.</li><br>
  <li> Go into "IoTMyAdmin/includes" open the "dbConfig.php" file with your text editor and edit these lines with your database parameters:<br><br>
        <i>define("HOST", "localhost");    		// The host you want to connect to. </i><br>
        <i>define("USER", "root"); 			      // The database username. </i><br>
        <i>define("PASSWORD", "root");         // The database password. </i><br>
        <i>define("DATABASE", "IoTMyAdmin");   // The database name. </i></li><br>
</ol>

Now you can log in into your IoTMyAdmin accessing with your web browser to the URL "<b>youtHostName.com</b>/IoTMyAdmin".<br>
## Usage

First of all, you need to register your new user. You can use your real email or a fake one. There is not email confirmation process.
By default a test user is registered, so you can log in as testuser@test.com/Password123 (be careful with the capital 'P')

Once you are logged in, a simple menu on the left side allows you to navigate between the different pages.
<ol>
  <li>Home: Summarize content statistics</li>
  <li>List: list of registered devices</li>
  <ul>
    <li><i> Clicking on "Add Device" you can register new devices</i></li>
    <li><i> Clicking on "Details" you can customize some device features and copy the custom Arduino code for data insertion</i></li>
  </ul>
  <li>Last Logs: Shows a table with the last logs</li>
  <li>Data Tables: Shows the data tables for each device</li>
  <li>Charts: Represent device data with different charts</li>
  <li>Maps: Represent uploaded coordinates from location devices using google maps</li>
  <li>Tutorials: Some tutorials about how to use the web site and upload data</li>
  <li>Arduino projects: Some Arduino projects. Two of them upload data using a WiFi Shield or a Adafruit FONA GSM/GPRS module</li>
</ol>
IMPORTANT NOTE: Each device has its own password, which is needed to change its features or upload data.<br>
Two devices are registered by default. Both have the same password "password".<br><br>
For more details, follow the tutorials in the web.<br>

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

14/Jul/2015: First version released

## Future goals

<ol>
  <li>Add different profile roles</li>
  <li>Add profile clusters for device sharing</li>
  <li>Allow web-device communication</li>
  <ul><li>Custom HTTP response can be interpreted by Arduino</li></ul>
  <li>Profile messaging services</li>
  <li>Improve charts representation</li>
  <li>Add statistics</li>
  <li>Code for other devices (Android, iOS, Desktop apps)</li>
</ol>

## Credits

Written by Rafael López Martínez in 2015

Libraries, frameworks and other tools used:
<ul>
  <li>SB Admin template (<a target="_blank" href="http://startbootstrap.com/template-overviews/sb-admin/">link</a>).</li>
  <li>Twtter Bootstrap (<a target="_blank" href="http://getbootstrap.com/">link</a>).</li>
  <li>JQuery (<a target="_blank" href="https://jquery.com/">link</a>).</li>
  <li>Google Charts API (<a target="_blank" href="https://developers.google.com/chart/">link</a>).</li>
  <li>Google Maps API (<a target="_blank" href="https://developers.google.com/maps/web/">link</a>).</li>
  <li>phpSecureLogin (<a target="_blank" href="https://github.com/peredurabefrog/phpSecureLogin">link</a>).</li>
  <li>Font Awesome Icons(<a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">link</a>).</li>
</ul>

## License

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
