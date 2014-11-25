        <div id="footer">
            {if isset($mysql)}
                {#Number_of_MySQL_queries#}: {$mysql.count}<br>
                {#Time_of_MySQL_queries#}: {$mysql.time}
            {/if}
        </div>
    </div>
</div>
</body>
</html>
