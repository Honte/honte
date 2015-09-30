<script type="text/javascript">
<?php 

		$options = '
			
			mode : "textareas",
			theme : "advanced",
			plugins : "safari, table, paste, save, print, searchreplace, preview, contextmenu",
			
			theme_advanced_buttons1 : "undo, redo, |, bold, italic, underline, strikethrough, |, formatselect, forecolor, backcolor, |, link, unlink, code, |, pastetext, pasteword",
			theme_advanced_buttons2 : "justifyleft, justifycenter, justifyright, justifyfull, |, bullist, numlist, |, outdent, indent, blockquote, |, sub, sup, |, search, replace",
			theme_advanced_buttons3 : "tablecontrols",
			theme_advanced_blockformats : "p,h2,h3,h4,h5,h6,blockquote",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_path_location : "",
			relative_urls : false,
			content_css : "'.$html->url('/css/tiny.css').'",
			document_base_url : "'.$html->url('/files/upload/').'"
		';
?>
tinyMCE.init({<?php echo($options); ?>});

function toggleEditor(id) {
	if (!tinyMCE.get(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}
</script> 