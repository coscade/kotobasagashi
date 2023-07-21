<?php
if (!isset($afm_random)) {
    $afm_random = get_table_data($dbconn, "v_afm_random", "", "");
}
?>
<!--↓全体-->
<table width="762" border="0" cellspacing=0 cellpadding=0>
    <tr valign="top">
        <td width="10">
            <img src="/img/1pix0000.gif" alt=width="10" height="1">
        </td>
        <td width="731">
            <!--↓コンテンツ-->
            <table width="731" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="170">
                        <a href="/">
                            <img src="/img/top_title01.jpg" alt="ことば探し" width="170" height="64">
                        </a>
                    </td>
                    <td width="561" background="/img/top_title02.jpg" valign="top">
                        <table width="561" border="0" cellspacing="0" cellpadding="10">
                            <tr>
                                <td valign="top">
                                    <marquee behavior="slide" scrolldelay="50" scrollamount="6">
                                        <a href="/afm.php?afm_id=<?= $afm_random['afm_id'] ?>">
                                            <font color="ffffff" size="2">★<?= $afm_random['afm_value'] ?>★</font>
                                        </a>
                                    </marquee>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

