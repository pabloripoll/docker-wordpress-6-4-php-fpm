<?= $this->private(); ?>

<div class="wrap"><!-- wp-class -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="wp-heading-inline">PR Custom</h1><!-- wp-class -->
            <hr class="wp-header-end">
        </div>
        <ul class="subsubsub"><!-- wp-class -->
            <li class="all">
                <a href="javascript:;" class="spapage current" data-target="index">Index <span class="count"></span></a> |
            </li>
            <li class="publish">
                <a href="javascript:;" class="spapage" data-target="setting">Setting <span class="count"></span></a> |
            </li>
            <li class="publish">
                <a href="javascript:;" onclick="wp_ajax_test()">WP Ajax Test</a>
            </li>
        </ul>
        <div id="section-content" class="col-md-12"></div>
    </div><!-- /.col-md-12 -->

    <!-- plugin js object -->
    <script>
        // mandatory to use jquery in plugin js scripts
        const $ = jQuery.noConflict();

        //
        const PrCustom = {
            ajaxUrl: '/wp-admin/admin-ajax.php',
            ajaxWpCall: 'pr_custom_admin_ajax',
            ajaxWpNonce: '<?= $nonce ?>',

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
        function asyncContent(section = 'index', payload = {}) {
            payload.view = {
                section: section
            }
            PrCustom.ajaxContent(payload).then((response) => {
                $('#section-content').html(response)
            }).catch((error) => {
                $('#section-content').html(error)
            })
        }

        let pagelink = $('.spapage')
        pagelink.on('click', function(event) {
            pagelink.each(function() {
                $(this).removeClass(`current`)
            })
            event.stopPropagation()
            event.stopImmediatePropagation()

            let elem = $(this)
            elem.addClass(`current`)
            asyncContent(elem.data().target)
        })

        asyncContent('index');
    </script>
</div>