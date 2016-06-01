<?php
return array(
    '_root_' => 'special/login', // The default route
    'user/:id' => 'user/index',
    'login' => 'special/login',
    'logout' => 'special/logout',
    'bbnew' => 'survey/bbnew',
    '_404_' => 'welcome/404', // The main 404 route
    'check' => 'special/check',
    'mydivn' => 'survey/mydivn',
    'myvill' => 'survey/myvill',
    'myhab' => 'survey/myhab',
    'hierarchy' => 'wing/indexall',
    'wing/:id' => 'wing/index',
    'scheme/:id' => 'scheme/index',
    'billjob/:filter/:page' => 'billjob/pagedIndex',
    'billjobs/billgroup/:id' => 'billjob/billgroup',
    'billgroups' => 'billgroup/index',
    'billgroups/:id' => 'billgroup/index',
    'billgroup/habitations/:id' => 'billgroup/habitations',
    'bghabitations/:billgroup_id/:habitation_id' => 'billgroup/habitations',
    'circle/:id' => 'circle/index',
    'circles/wing/:id' => 'circle/wing',
    'district/:id' => 'district/index',
    'districts/circle/:id' => 'district/circle',
    'division/:id' => 'division/index',
    'divisions/district/:id' => 'division/district',
    'subdivision/:id' => 'subdivision/index',
    'subdivisions/division/:id' => 'subdivision/division',
    'block/:id' => 'block/index',
    'blocks/subdivision/:id' => 'block/subdivision',
    'panchayat/:id' => 'panchayat/index',
    'panchayats/block/:id' => 'panchayat/block',
    'village/:id' => 'village/index',
    'villages/panchayat/:id' => 'village/panchayat',
    'habitation/:id' => 'habitation/index',
    'habitations/block/:id' => 'habitation/block',
    'habitations/village/:id' => 'habitation/village',
    'habitations/scheme/:id' => 'habitation/scheme',
    'habitations/transactions/:id' => 'habitation/transactions',
    'habitationtransactions' => 'habitationtransaction/index',
    'habitationtransactions/:id' => 'habitationtransaction/index',
    'consumer/:id' => 'consumer/index',
    'consumers/habitation/:id' => 'consumer/habitation',
    'consumers/scheme/:id' => 'consumer/scheme',
    'accountsearch' => 'consumer/accountsearch',
    'accountstatus' => 'consumer/accountstatus',
    'accountfine' => 'consumer/accountfine',
    'account/:id' => 'consumer/account',
    'payment/:id' => 'payment/index',
    'payments/consumer/:id' => 'consumer/last_xx_payments',
    'reports/payments2' => 'payment/payments2',
    'reports/overdue' => 'reports/overdue',
    'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    'export/wings/:id' => 'wing/export',
    'export/circles/wing/:id' => 'circle/export',
    'export/districts/circle/:id' => 'district/export',
    'export/divisions/district/:id' => 'division/export',
    'export/subdivisions/division/:id' => 'subdivision/export',
    'export/blocks/subdivision/:id' => 'block/export',
    'export/panchayats/block/:id' => 'panchayat/export',
    'export/villages/panchayat/:id' => 'village/export',
    'export/habitations/village/:id' => 'habitation/export',
    'export/consumers/habitation/:id' => 'consumer/export',
    'mapdata/:id' => 'mapdata/index',
    'billingexport/:id' => 'getfile/billingexport',
    'collectioncenter/:id' => 'collectioncenter/index',
    'changepassword' => 'user/changepassword',
    'auditlog/:id' => 'auditlog/index',
    'transaction/:id' => 'consumer/transaction',
    'ledger' => 'consumer/ledger',
    'statmonths' => 'stats_wing/months',
    'wingstats/:id' => 'stats_wing/index',
    'circlestats/:id/:date' => 'stats_circle/index',
    'districtstats/:id/:date' => 'stats_district/index',
    'divisionstats/:id/:date' => 'stats_division/index',
    'subdivisionstats/:id/:date' => 'stats_subdivision/index',
    'blockstats/:id/:date' => 'stats_block/index',
    'panchayatstats/:id/:date' => 'stats_panchayat/index',
    'blockstats/:id/:date' => 'stats_block/index',
    'villagestats/:id/:date' => 'stats_village/index',
    'habitationstats/:id/:date' => 'stats_habitation/index'
);