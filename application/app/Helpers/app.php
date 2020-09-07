<?php
/**
 * [Application Domain url end with slash(/)]
 */
function appURL() {
    return Str::finish(config('app.url'), '/');
}
