<?php

echo <<<HTML
        <form method='post' action='/publishers' enctype="multipart/form-data">

            <h2 class="form-title">Új kiadó hozzáadása</h2>

            <div class="form-group">
                <label for="name">Kiadó</label>
                <input type="text" name="name" id="name">
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