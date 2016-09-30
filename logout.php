<?php

/* This needs to be here in order for sessions to work */
session_start();

/* Unsets all the current sessions */
session_unset();

/* All the sessions are completely removed */
session_destroy();

/* Redirects to the homepage */
header("Location: /");