
<b>Istruzioni per l'installazione.</b>
Scaricare il pacchetto zippato, dopo aver decompressi il pacchetto caricare cartelle e file dell'estensione nella cartella "ext/micogian/forum:readers/"

E' necessaria una modifica al file ./template/forumlist_body.html" perchè non esiste un "EVENT" nella posizione voluta.
Aprire il file "forumlist_body.html",
trovare la line di codice
<code><a href="{forumrow.U_VIEWFORUM}" class="forumtitle">{forumrow.FORUM_NAME}</a></code>
aggiungere la seguente riga di codice
<code><!-- EVENT forumlist_body_readers --></code>

Salvare e da PCA abilitare l'estensione.
