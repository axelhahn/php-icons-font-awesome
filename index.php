<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Font awesome icon classes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" media="screen" href="main.css">
</head>
<body>

    <h1>Font awesome icon classes</h1>
    <p>
        Search trough fontawesome icon classes...<br>
    </p>
    <div class="main">
        <p>
            You can filter the list by typing some keywords seperated with space in the filter field. They will be applied with AND condition.<br>
            Click on a wort of the label or search tags to add that word in the filter field.
        </p>

        <?php
        require_once "classes/fa-icons.class.php";

        $oIcons = new Fa_icons();

        $sTable="";
        foreach($oIcons->getClassList() as $sKey => $aData) {
            $sSearch="";
            $sLabel="";
            foreach(explode(" ", $aData['label']) as $sTerm) {
                $sLabel.="<a href=\"#\" onclick=\"filter(this); return false;\">".trim($sTerm)."</a> ";
            }
            foreach($aData['search'] as $sTerm) {
                $sSearch.="<a href=\"#\" onclick=\"filter(this); return false;\">".trim($sTerm)."</a> ";
            }
            $sTable.="<tr>
                <td><i class=\"$sKey\"></i></td>
                <td><code>$sKey</code></td>
                <td><strong>$sLabel</strong>".($aData['brand'] ? "🏷️" : "")."<br><div class=\"search\">$sSearch</div></td>
                <!-- <td>".($aData['free'] ? "Free" : "Paid")."</td> -->
                </tr>\n";
        }
        ?>

        <table id="tblIcons">
            <?php echo $sTable; ?>
        </table>
    </div>

    <script type="text/javascript" language="javascript" src="/js/functions.js"></script>
</body>
</html>