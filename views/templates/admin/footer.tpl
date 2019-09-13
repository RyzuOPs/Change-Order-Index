<div class="panel">

    <b>{l s='Status:'}</b> 
    
    <table class="table">
        <tr>
            <td>
                {* Check if module is enabled (in module manager)*}
                {l s='Module is installed and' mod='changeorderindex'}
                <b>
                {if $changeorderindex_enabled}
                    {l s='enabled' mod='changeorderindex'}
                {else}
                    {l s='disabled' mod='changeorderindex'}
                {/if}
                </b>
            </td>

            <td>
                <span class="badge badge-{if $changeorderindex_enabled}success{else}warning{/if}">
                {if $changeorderindex_enabled}
                    {l s='OK' mod='changeorderindex'}
                {else}
                    {l s='Disabled' mod='changeorderindex'}
                {/if}
                </span>
            </td>
        </tr>
        <tr>
            <td>
                {* Check if override is enabled (in module settings)*}
                {l s='Override is' mod='changeorderindex'} 
                <b>
                {if $changeorderindex_override_enabled}
                    {l s='enabled' mod='changeorderindex'}
                {else}
                    {l s='disabled' mod='changeorderindex'}
                {/if}
                </b>
            </td>
            <td>
                <span class="badge badge-{if $changeorderindex_override_enabled}success{else}warning{/if}">
                    {if $changeorderindex_override_enabled}
                        {l s='OK' mod='changeorderindex'}
                    {else}
                        {l s='Disabled' mod='changeorderindex'}
                    {/if}
                </span>
            </td>
        </tr>
        <tr>
            <td>
                {* Check if override file exists*}
                {l s='Override file:' mod='changeorderindex'} <b>/override/classes/order/Order.php</b>
                {if $changeorderindex_overrideok} 
                    {l s='exists' mod='changeorderindex'} 
                {else}
                    {l s='does not exist! You can try reinstall module to fix this.' mod='changeorderindex'}
                {/if}
            </td>
            <td>
                <span class="badge badge-{if $changeorderindex_overrideok}success{else}warning{/if}">
                {if $changeorderindex_overrideok}
                    {l s='OK' mod='changeorderindex'}
                {else}
                    ERROR
                {/if}
                </span>
            </td>
        </tr>
    </table>
</div>
