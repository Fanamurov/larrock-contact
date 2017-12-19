<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color: #dcdcdc; height: 100% !important;
    margin: 0;
    padding: 0;
    width: 100% !important; border-collapse: collapse !important;">
        <tr>
            <td align="center" valign="top">
                <!-- BEGIN TEMPLATE // -->
                <table border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid #FFFFFF;">
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN HEADER // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td valign="top" class="headerContent">
                                        <a href="{{ env('APP_URL') }}" target="_blank">
                                            <img src="{{ env('APP_URL') }}/_assets/_front/_images/logo.png" style="max-width:600px; padding: 20px;" />
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <!-- // END HEADER -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN BODY // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 20px; background-color: #F4F4F4; border-top: 1px solid #FFFFFF;
    border-bottom: 1px solid #CCCCCC;">
                                <tr>
                                    <td valign="top" class="bodyContent">
                                        @yield('content')
                                    </td>
                                </tr>
                            </table>
                            <!-- // END BODY -->
                        </td>
                    </tr>
                    @yield('footer')
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>