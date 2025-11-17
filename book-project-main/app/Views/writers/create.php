<?php

echo <<<HTML
        <form method='post' action='/writers' enctype="multipart/form-data">

        <h2 class="form-title">Új szerző hozzáadása</h2>

            <div class="form-group">
                <label for="name">Író</label>
                <input type="text" name="name" id="name">
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea type="text" name="bio" id="bio" class="bio"></textarea>
            </div>
                
            <div class="form-actions">
                <button type="submit" name="btn-update" class="btn-update">
                    <i class="fa fa-save"></i> Mentés
                </button>
                <a href="/writers" class="btn-cancel">
                    <i class="fa fa-cancel"></i> Mégse
                </a>
            </div>
        </form>
    HTML;