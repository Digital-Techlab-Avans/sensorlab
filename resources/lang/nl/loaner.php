<?php
require_once 'shared.php';

return [

    //HOMEPAGE
    'home_page.title' => 'Welkom :name',
    'home_page.all_products_link' => 'Bekijk alle Producten',
    'home_page.returns_link' => 'Inleveren Producten',
    'home_page.category.featured' => CATEGORIES,
    'home_page.category.title' => CATEGORIES,
    'home_page.search.placeholder' => 'Ik ben op zoek naar ...',
    'home_page.secure.products' => 'Verkrijgbaar op aanvraag. Klik voor meer info',
    'home_page.search.description' => 'Zoek ook in product omschrijving',

    // PRODUCT SEARCH
    'product_search.name' => 'Naam',
    'product_search.new' => 'Datum toegevoegd',

    //OVERVIEW
    'overview.title' => 'Producten',
    'overview.empty_message' => 'Geen producten om weer te geven',
    'overview.secure.products' => 'Verkrijgbaar op aanvraag. Klik voor meer info',
    'overview.no_loan_registration.products' => 'Dit product kan je lenen zonder registratie',
    'overview.show_more' => 'Toon Meer',

    //HAND_IN
    'hand_in.title' => 'Inleveren producten',
    'hand_in.extra_title_information' => 'Voeg bij defecten of andere opmerkingen bij het desbetreffende product een opmerking toe',
    'hand_in.submit.button' => 'Producten inleveren',
    'hand_in.empty_message' => 'Je hebt op dit moment geen producten geleend.',

    //INDEX
    'index.title' => 'Geselecteerde producten',
    'index.products.message' => 'Dit zijn alle producten die je op dit moment hebt toegevoegd om te lenen',
    'index.products.due_date.message' => 'Gelieve de producten uiterlijk in te leveren',
    'index.submit.button' => 'Lening verzenden',
    'index.products.empty.message' => 'Je hebt geen producten geselecteerd',
    'index.products.add.message' => 'Je hebt geen producten geselecteerd',
    'index.loaning.button' => 'Zoek producten om te lenen',

    //ACCOUNT
    'account.title' => 'Hallo :name',
    'account.hand_in.message_header' => 'Inleveren',
    'account.hand_in.message' => 'Kom je geleende producten weer inleveren?',
    'account.hand_in.button' => 'Lever producten in',
    'account.returns.message_header' => 'Status inleveringen',
    'account.status_returns_message' => 'Je hebt :amount keer producten ingeleverd.',
    'account.status_returns_button' => 'Bekijk inlever status',
    'account.settings.button' => 'E-mail settings',
    'account.logout' => 'Uitloggen',


    //SETTINGS
    'settings.title' => 'Email voorkeuren',
    'settings.turnin.title' => 'Inlever herinneringen',
    'settings.turnin.oneweek' => 'Herinnering een week van te voren',
    'settings.turnin.sameday' => 'Herinnering op de dag zelf',
    'settings.status.title' => 'Status updates',
    'settings.status.message' => 'Inlevering is goed of afgekeurd door admin',
    'settings.reset' => 'Reset',
    'settings.save' => 'Opslaan',


    //RETURNS
    'returns.title' => 'Inleveringen',
    'returns.empty.message' => 'Er zijn geen inleveringen.',
    'returns.pending.returns.empty.message' => 'Er zijn geen inleveringen in afwachting.',
    'returns.accepted.returns.empty.message' => 'Er zijn geen inleveringen goedgekeurd.',
    'returns.denied.returns.empty.message' => 'Er zijn geen afgekeurde inleveringen.',
    'returns.pending.returns.tab.title' => 'In afwachting',
    'returns.accepted.returns.tab.title' => 'Goedgekeurd',
    'returns.denied.returns.tab.title' => 'Afgekeurd',
    'returns.all.returns.tab.title' => 'Alle',
    'returns.approved_status' => APPROVED,
    'returns.rejected_status' => REJECTED,
    'returns.pending_status' => PENDING,

    //PRODUCT DETAILS
    'product_details.secure.products' => 'Ga naar de admin om dit product te kunnen lenen',
    'product_details.product.information' => 'Product Informatie',
    'product_details.no_loan_registration.products' => 'Dit product kan je lenen zonder registratie',
    'product_details.product.description' => DESCRIPTION,
    'product_details.empty.message' => 'Er is nog geen product informatie toegevoegd.',

    //SEARCH
    'search_bar.empty_message' => 'Geen Producten Gevonden',

    //TOAST
    'toast.go_to_checkout' => 'Ga naar winkelwagen',

    'filter_and_sort.title' => 'Filteren & Sorteren',
    'filter_and_sort.categories' => CATEGORIES,
    'filter_and_sort.sort' => 'Sorteer',
    'filter_and_sort.order' => 'Volgorde',
    'filter_and_sort.asc' => 'Oplopend',
    'filter_and_sort.desc' => 'Aflopend',
    'filter_and_sort.reset' => 'Reset Filter',
];
