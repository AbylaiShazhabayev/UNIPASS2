<div id="modalCompartilhar" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <table id="tableCompartilhamentos" class="table table-hover table-outline table-vcenter text-nowrap card-table w-100 border-top">
                <thead>
                <th>Shared with</th>
                <th>Permissions</th>
                <th></th>
                </thead>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.getScript("{{ asset($assets . '/js/passwords-shareds.js?') . $version }}");
</script>
