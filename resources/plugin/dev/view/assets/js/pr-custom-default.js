// --- test area --- //

function wp_ajax_test() {
    PrCustom.ajaxPost({
        'method': 'example'
    }).then((response) => {
        alert(`Backend method: ${response.data.method}()`)
    }).catch((error) => {
        alert(error)
    })
}

// --- table --- //

function createUsersJsonFile() {
    PrCustom.ajaxPost({
        'method': 'createUsersJsonFile'
    }).then((response) => {
        alert(`users.json created`)
        asyncContent('index')
    })
}

function resetUsersJsonFile() {
    $('#modal-dialog').modal('hide')
    PrCustom.ajaxPost({
        'method': 'emptyUsersJsonFile'
    }).then((response) => {
        alert(`users.json has been set empty`)
        asyncContent('index')
    })
}

function emptyUsersJsonFile() {
    $('#modal-dialog').modal('show')
}

function cancelEmptyUsersJsonFile() {
    $('#modal-dialog').modal('hide')
}


// filters

function listUsersByFilter(page = null) {
    if (! page) page = 1;
    let filter = {
        page: page,
        name: $('#filter-name').val(),
        email: $('#filter-email').val(),
        surname: $('#filter-surname').val()
    }
    asyncContent('index', {filter: filter})
}

$(document).keydown('.filter-input', function(event) {
    event.stopPropagation()
    event.stopImmediatePropagation()
    if (event.which == 13) {
        listUsersByFilter()
        event.preventDefault()
    }
})

$(document).on('click', '#filter-button', function(event) {
    event.preventDefault()
    listUsersByFilter()
})

function clearListUsersByFilter() {
    $('#filter-name').val(''),
    $('#filter-email').val(''),
    $('#filter-surname').val('')
    listUsersByFilter()
}

/* $(document).keyup('#filter-clear-button', function(event) {
    if (event.which == 13) {
        clearListUsersByFilter()
        event.preventDefault()
    }
}) */

$(document).on('click', '#filter-clear-button', function(event) {
    clearListUsersByFilter()
    event.preventDefault()
})

// pagination

$(document).on('click', '.tablenav-pages-navspan', function(event) {
    event.stopPropagation()
    event.stopImmediatePropagation()
    let elem = $(this)
    if (! elem.disabled) {
        listUsersByFilter(elem.data().target)
    }
})
