<?php

/*
    CORE APPLICATION CONSTANTS
*/

const ADMIN_REDIRECTION_URL = 'dashboard';
const APPLICATION_MODE_PRODUCTION = 'production';
const APPLICATION_MODE_DEVELOPMENT = 'development';
const APPLICAT_DEFALT_PERMISSION_VERSION = 1;


/*
    CACHE GENERATE CONST
*/

const CACHE_STORE_TIME = 60; // in minutes

/*
    LOG GENERATE CONST
*/

const LOG_ACTION_KEY = 'action';
const STATUS_CODE_KEY = 'status';
const MESSAGE_CODE_KEY = 'message';
const LOG_EMERGENCY_KEY = 'emergency';
const LOG_ALERT_KEY = 'alert';
const LOG_CRITICAL_KEY = 'critical';
const LOG_ERROR_KEY = 'error';
const LOG_WARNING_KEY = 'warning';
const LOG_NOTICE_KEY = 'notice';
const LOG_INFO_KEY = 'info';
const LOG_DEBUG_KEY = 'debug';
const CATCH_EXCEPTION_LOG_NAME = 'EXCEPTION_CAUGHT';
const CURL_REQUEST = 'CURL_REQUEST';

/*
    DATA TABLES
*/

const DATA_TABLES_PER_PAGE = 'Per Page';
const DATA_TABLES_PAGINATION_LIMIT = 5;
const DATA_TABLES_PER_PAGE_SHOW = [
    0 => 5,
    1 => 10,
    2 => 25,
    4 => 50,
    5 => 100,
];

const DATE_RANGE_SEPARATOR = ' To ';

// encryption keys
const ENCRYPTION = 'encryption';
const DECRYPTION = 'decryption';

// SWTTET ALART MODAL TIMER
const SWTET_ALERT_MODAL_TIMER = 5000;
