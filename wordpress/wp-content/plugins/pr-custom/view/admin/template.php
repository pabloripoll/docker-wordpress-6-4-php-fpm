<?= $this->private(); ?>

<div class="wrap">
    <div class="row">
        <div class="col-md-12">
            <h1 class="wp-heading-inline">PR Custom</h1> <small>A fancy Wordpress plugin stater sample.</small>
        </div>
    </div>
    <hr class="wp-header-end">

    <?= $this->view('admin._common.navigation', ['sections' => $route['sections']]); ?>

    <!-- plugin js object -->
    <script>
        // mandatory to use jquery in plugin js scripts
        const $ = jQuery.noConflict();
        const nonce = '<?= $nonce ?>'

        let board = '<?//= $page->board ?>'
    </script>
    <script>
        //
        const PrCustom = {
            ajaxUrl: '/wp-admin/admin-ajax.php',
            ajaxWpCall: 'pr_custom_admin_ajax',
            ajaxWpNonce: nonce,

            ajaxPayload(payload) {
                payload.nonce = this.ajaxWpNonce,
                payload.action = this.ajaxWpCall

                return payload
            },

            async ajaxBackend(method, payload = {}) {
                return $.ajax({url: this.ajaxUrl, type: method, data: payload})
            },

            async ajaxGet(payload = {}) {
                return this.ajaxBackend('GET', this.ajaxPayload(payload))
            },

            async ajaxPost(payload = {}) {
                return this.ajaxBackend('POST', this.ajaxPayload(payload))
            },

            async ajaxContent(payload = {}) {
                return $.ajax({url: this.ajaxUrl, type: 'POST', data: this.ajaxPayload(payload), dataType: 'html'})
            },
        }

        //
        function asyncContent(section, payload = {}) {
            payload.view = {section: section}

            PrCustom.ajaxContent(payload).then((response) => {
                $('#section-content').html(response)
            }).catch((error) => {
                $('#section-content').html(error)
            })
        }

        let pagelink = $('.spapage'); pagelink.on('click', function(event) {
            pagelink.each(function() {
                $(this).removeClass(`current`)
            })
            event.stopPropagation()
            event.stopImmediatePropagation()

            let elem = $(this)
            elem.addClass(`current`)
            asyncContent(elem.data().target)
        })
    </script>
</div>