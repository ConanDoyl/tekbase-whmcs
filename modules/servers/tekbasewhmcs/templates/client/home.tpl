<script>
    var ServerId = {$id};
</script>
{literal}
<script>
    function openTab(evt, cityName) {
      // Declare all variables
      var i, tabcontent, tablinks;
    
      // Get all elements with class="tabcontent" and hide them
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
    
      // Get all elements with class="tablinks" and remove the class "active"
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
    
      // Show the current tab, and add an "active" class to the button that opened the tab
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    function requestData(url, formdata, callback){
     	$.ajax({
            type: 'POST',
            crossDomain: false,
            url: 'clientarea.php?action=productdetails&id=' + ServerId + url,
            data: formdata,
            success: function(respond){
             	callback(respond);
            },
            error: function(response){
                console.log(response);
            }
        });
    };



    function SaveSettings(){
        $siteurl = $('#siteurl').val();
        $sitepath = $('#sitepath').val();
        requestData('&modop=custom&a=saveClientSettings', { siteurl: $siteurl, sitepath: $sitepath }, function(response){
            $('#infobox').addClass('successboxtek')
            if (response.result === "success"){
                $('#infobox').addClass('successboxtek');
                $('#infobox').html(response.message);
                $('#infobox').removeClass('hidden');
            } else {
                $('#infobox').addClass('alertboxtek');
                $('#infobox').html(response.message);
                $('#infobox').removeClass('hidden');
            }
        });
    }

</script>
{/literal}


<link rel="stylesheet" href="modules/servers/tekbasewhmcs/templates/assets/css/main.css">

<!-- Tab links -->
<div class="tab">
    <button class="btn btn-primary tablinks" onclick="openTab(event, 'info')">TekBase Installationshilfe</button>
    <button class="btn btn-primary tablinks" onclick="openTab(event, 'key')">TekBase Lizenzschlüssel</button>
    <button class="btn btn-primary tablinks" onclick="openTab(event, 'change')">TekBase Einstellungen</button>
</div>
   
   
   <div id="info" class="tabcontent">
     <center><h3><b>TekBase Installationshilfe</b></h3></center>
     <br /><br /> 
     <b>Automatische Installation für Linux</b><br />
     
     <p>Verbinde dich mit deinem Linux Server. Nach dem Login können wir mit den vorbereitungen für die TekBase Installation beginnen.<br />
     Zuerst navigieren wir in unser /home/ Verzeichnis, dazu führen wir <code>cd /home/</code> aus. Dort angekommen, können wir auch schon den Auot-Installer runterladen.<br />
     Hierzu führen wir den Befehl <code>wget https://teklab.s3.amazonaws.com/tekbase_newinst.tar</code> aus. Dieser sollte nun das Archiv runterladen und in unseren /home/ Ordner ablegen.<br />
     Nun müssen wir das Archiv mit <code>tar xfv tekbase_newinst.tar</code> entpacken. Nun räumen wir auf indem wir das Archiv löschen, dieses wird nicht mehr benötigt.<br />
     Dazu führen wird <code>rm tekbase_newinst.tar</code> aus. Nun kommen wir zum Auto-Installer. Starten wir nun mithilfe von <code>./install.sh</code> ab hier fragt uns der Installer bei jeden weiteren Schritt<br />
     Nach Abschluß der Installation, wird der Installer (sofern installiert) die Teamspeak3-Server Quary Informationen sowie den Token für die ServerAdmin Rechte anzeigen. Kurz darauf ist die Installation vollständig abgeschlossen<br />
     Hier teilt uns der Installer dann mit unter welcher URL wir TekBase aufrufen können und wie wir den Linux Deamon starten.
     <br />
     <b><br />Die Zugangsdaten der Automatischen Einrichtung:<br />
     Username: admin<br />
     Password: 1q2w3e4r5t</b><br />
     <br />
     <underline><font color="#FF0000">Diese Zugangsdaten sollten <b>definitiv</b> direkt geändert werden!</font></underline><br />
     <br />
     Im Webinterface angemeldet, können wir unter Einstellungen nun den Lizenzschlüssel eingeben und TekBase aktivieren.<br /></p>
     
   </div>
   
   <div id="key" class="tabcontent">
     <center><h3>Lizenzschlüssel</h3></center>
     <br />
       <center><h4><font color="#FF0000">Stelle sicher das in deiner config.php $ipv6=1; eingetragen ist. Die Datei ist im Hauptinstallation Verzeichnis von TekBase zu finden.</font></h4>
       <p> Zum eintragen des Schlüssels, logge dich im Tekbase Webinterface ein und klicke auf Einstellungen und trage nachfolgenden Code dort ein und speichere es ab.</p>
       <p>
           {foreach from=$tplVars.License_Key item=line}
               {$line}<br />
           {/foreach}
       </p>
       </center>
   </div>
   
   <div id="change" class="tabcontent">
     <center><h3>Einstellungen</h3></center>
     <br />
           <p>Hier kannst du die Einstellungen deiner TekBase Installation ändern. Zum Beispiel kannst du deine Lizenz auf eine andere Domain/IP-Adresse umschreiben.<br />
           Dies ist Sinnvoll wenn man TekBase vorher nur auf einen Test-System installiert hatte, und später erst auf das richtige System wechseln möchtest.<br />
           Sollte man bei sich bei der Bestellung vertippt haben oder gar vergessen haben, Site-URL und Path zu setzen, kann man es hier nachholen und somit seine Lizenz selbst freischalten.</br>
           <br /><font color="#FF0000"><b>Info</b> Nach den Absenden muss dieser Tab wieder geöffnet werden um die Antwort zu sehen!</font>
           </p>
           
   
               <center>
               <div class="">
               
                   <br />
                       
                 <div id="infobox" class="hidden"></div>
                           
            

   
                   <div class="row">
                       <span class="col-md-6">
                           <label class="field" for="siteurl" title="Insert the site Url e.g http://domain.tld/tekbase/admin.php">Site URL<font color="#FF0000">*</font></label><br />
                           <input style="min-height: 35px !important; padding: 4px 20px !important; webkit-box-shadow: 1px 1px 10px 0 rgba(90,90,90,1) !important;     border: 1px solid #c3c3c3 !important;"  height="15px" width="250px" class="tektxt" id="siteurl" title="Customer unique ID, also known as Username at the automated process" name="siteurl" placeholder="http://domain.tld/tekbase/admin.php" type="text">
                       </span>
                       
                       <span class="col-md-6">
                           <label class="field" for="sitepath" title="Insert the site path where tekbase is located">Site Path<font color="#FF0000">*</font></label><br />
                           <input style="min-height: 35px !important; padding: 4px 20px !important; webkit-box-shadow: 1px 1px 10px 0 rgba(90,90,90,1) !important;     border: 1px solid #c3c3c3 !important;"  height="15px" width="250px" class="tektxt" id="sitepath" title="Insert the site path where tekbase is located" name="sitepath" placeholder="E.g /var/www/html/tekbase" type="text">
                       </span>
                   </div>
                   <p> <font color="#FF0000">*</font> - Required field! </p>
                   
                   <br /><br />
                   <button class="btntek" onclick="SaveSettings()" type="submit">Speichern</button>
                   <br /><br />
               
               </div></center>
               
   
               
       </center>
   </div>
   