<?php return '<div class=\'input-group\'>

    <select class="custom-select" id=\'selector-contributors\'>
        <option value=\'-1\'>Select contributor...</option>
                        <option data-avatar=""value=1>admin</option>
                            <option data-avatar=""value=10>administrator</option>
                            <option data-avatar=""value=11>author</option>
                            <option data-avatar=""value=12>contributor</option>
                            <option data-avatar=""value=13>subscriber</option>
                        </select>
    <button type="button" class="button tag-add" id="add-contributor">Add</button>
</div>
<ul class=\'contributors-list\' id=\'editable-contributors-list\'>
                            <li data-id=1>
                    <span class="contributor-nickname">admin</span>
                    <input type="hidden" name=wp_contributors_plugin_value[] value=1>
                    <span class=\'fo fo-close\' >
                </li>
         
       
</ul>';
