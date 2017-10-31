# Dieses Skript generiert uns unsere Module in einem Rutsch
#
# Es wird euch von Ralf Köster zur Verfügung gestellt
#
# Verwendung des Skriptes ist auf eigene Gefahr, 
# Der Author übernimmt keinerleich Verantwortung!

# In welchem Verzeichnis liegt der Zielordner? \ am Ende nicht vergessen!
$zielpfad="C:\Users\Ralf\Enwicklung\download\src\"

# Wie soll der Zielordner heißen? Bei mir immer genauso, wie er in Zikula heißt
$zielordner="modules"

# Wo liegt der Generator?
$generator="C:\Users\Ralf\MostGenerator\ModuleStudio-generator.jar"

# Welche Module sollen in einem Rutsch generiert werden? 
# Bitte Modulnamen in Hochkommata und mit Komma getrennt ins Array schreiben
$module=@("Download")

# Damit der Generator die Module findet, müssen wir ihm noch sagen, wo die Module liegen. 
# Auch hier das \ am Ende nicht vergessen
$workspace="C:\Users\Ralf\MostWorkspace\"





# Ab hier ist die Konfiguration abgeschlossen.
# lasst das Skript für euch arbeiten :-)

# Wir müssen in den Zielpfad wechseln, weil sont der Modulordner nicht angelegt werden kann
cd $zielpfad


write-host "Die Generierung dauert immer ein wenig, weil das komplette Eclipse hochgefahren wird."
write-host "Bei mir dauert das pro Modul immer so etwa zwei Minuten."
write-host ""
write-host "Gönnt euch eine kurze Pause und steht einmal auf und holt euch eine Tasse Kaffee." -foregroundcolor red -backgroundcolor yellow
write-host "Beim Kaffeetrinken denkt gerne einmal darüber nach, was Axel uns da tolles zur Verfügung stellt!" -foregroundcolor red -backgroundcolor yellow
write-host ""
write-host ""
write-host ""
$startzeit=(get-date)

for ($i=0; $i -lt $module.length; $i++){
$pfad=$workspace+$module[$i] + "\" + $module[$i] + ".mostapp"
$zpfad=$zielpfad+$zielordner+"\vendor\"+$module[$i]
$j=$i+1
write-host "Generiere gleich: " $module[$i] "(" $j "von" $module.Length ")"
write-host "mit" $pfad
write-host "in " $zpfad
write-host "(Vendor ist abhängig vom Modul)"
write-host ""
write-host "das dauert jetzt ein Minütchen..."
write-host "Kaffee schon getrunken? ggf. nachschenken :-)"
write-host ""
java -jar $generator $pfad $zielordner
write-host "Fertig, "  -nonewline; write-host $module[$i] -foregroundcolor blue -backgroundcolor white  -nonewline; write-host " generiert"
write-host ""
write-host ""
write-host "********************************************************************"
write-host ""
write-host ""
}

write-host "********************************************************************"
write-host "TATA! Alle fertig! " -foregroundcolor green -backgroundcolor black
write-host ""
write-host ""
write-host "Angefangen um:" -nonewline; write-host $startzeit -foregroundcolor blue -backgroundcolor black
write-host "fertig geworden um:" -nonewline; write-host (get-date) -foregroundcolor blue -backgroundcolor black
write-host ""
write-host ""
read-host "Mit Enter Fenster schließen" -foregroundcolor green -backgroundcolor black