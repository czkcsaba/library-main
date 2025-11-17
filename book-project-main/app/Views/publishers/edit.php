<?php

echo <<<HTML
        <form method='post' action='/publishers' enctype="multipart/form-data">
            <input type='hidden' name='_method' value='PATCH'>
            <input type="hidden" name="id" value="{$publisher->id}">

            <h2 class="form-title">Kiadó szerkesztése</h2>

            <div class="form-group">
                <label for="name">Kiadó</label>
                <input type="text" name="name" id="name" value="{$publisher->name}">
            </div>
                
            <div class="form-actions">
                <button type="submit" name="btn-update" class="btn-update">
                    <i class="fa fa-save"></i> Mentés
                </button>
                <a href="/publishers" class="btn-cancel">
                    <i class="fa fa-cancel"></i> Mégse
                </a>
            </div>
        </form>
    HTML;