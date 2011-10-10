<h2>Creating pages</h2>
<p>
    To create a main page just create a folder with a index.tpl file in the ~/content folder. If you
    want sub pages, just create another *.tpl file in the same folder. The filename will be the title for subpages,
    the folder for the mainpage. Keep in mind its very important that there is a index.tpl file within the folder.
</p>
<h3>What shall the pages contain?</h3>
<p>
    .tpl files should only contain HTML code, but if you want to you can use variables that you can change in the
    corresponding PHP file. This would be ~/engine/content.php for content pages. Keep in mind that these variables
    will be set for every contentpage if you choose to add that variable.
</p>