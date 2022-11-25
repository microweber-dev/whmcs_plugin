<div class="panel panel-default mt-5 pt-5 mw-whm supportticketslist">
    <div class="header-lined text-center">
        <h1>{$LANG.MW_tickets}</h1>
    </div>
    {include file="$template/includes/tablelist.tpl" tableName="TicketsList" filterColumn="2"}
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var table = jQuery('#tableTicketsList').removeClass('hidden').DataTable();
            {if $orderby == 'did' || $orderby == 'dept'}
            table.order(0, '{$sort}');
            {elseif $orderby == 'subject' || $orderby == 'title'}
            table.order(1, '{$sort}');
            {elseif $orderby == 'status'}
            table.order(2, '{$sort}');
            {elseif $orderby == 'lastreply'}
            table.order(3, '{$sort}');
            {/if}
            table.draw();
            jQuery('#tableLoading').addClass('hidden');
        });
    </script>

    <div class="table-container table-responsive clearfix">
        <table id="tableTicketsList" class="table table-list hidden">
            <thead>
            <tr>
                <th>{$LANG.supportticketsdepartment}</th>
                <th>{$LANG.supportticketssubject}</th>
                <th class="status-column">{$LANG.supportticketsstatus}</th>
                <th>{$LANG.supportticketsticketlastupdated}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$tickets item=ticket}
                <tr onclick="window.location='viewticket.php?tid={$ticket.tid}&amp;c={$ticket.c}'">

                    <td>
                        {$ticket.department}
                    </td>
                    <td>
                        <a href="viewticket.php?tid={$ticket.tid}&amp;c={$ticket.c}" class="border-left">
                            <span class="ticket-number">#{$ticket.tid}</span>
                            <span class="ticket-subject{if $ticket.unread} unread{/if}">{$ticket.subject}</span>
                        </a>
                    </td>
                    <td class="status-column">
                        <span class="label status {if is_null($ticket.statusColor)}status-{$ticket.statusClass}" {else}status-custom" style="border-color: {$ticket.statusColor};
                        color: {$ticket.statusColor}"{/if}>
                        {$ticket.status|strip_tags}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="hidden">{$ticket.normalisedLastReply}</span>
                        {$ticket.lastreply}
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        <div class="text-center" id="tableLoading">
            <p><i class="fa fa-spinner fa-spin"></i> {$LANG.loading}</p>
        </div>
    </div>
</div>