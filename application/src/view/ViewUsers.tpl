<div>
    <h4>filter</h4>
    <table>
        <head>
            <tr>
                <th>category</th>
                <th>gender</th>
                <th>birthDate</th>
                <th>age</th>
                <th>ages</th>
            </tr>
        </head>

        <tr>

            <td>
                <select id="category">
                    <option></option>
                    <?php foreach ($data['categories'] as $category){ ?>
                    <?php if($data['filterCategory'] === $category['name']){ ?>
                    <option value="<?php echo $category['name']?>"
                            selected="selected"><?php echo $category['name'] ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $category['name']?>"><?php echo $category['name'] ?></option>
                    <?php } ?>

                    <?php } ?>
                </select>
            </td>

            <td>
                <select id="gender">
                    <option></option>
                    <?php foreach ($data['genders'] as $gender){ ?>
                    <?php if($data['filterGender'] === $gender['name']){ ?>
                    <option value="<?php echo $gender['name']?>"
                            selected="selected"><?php echo $gender['name'] ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $gender['name']?>"><?php echo $gender['name'] ?></option>
                    <?php } ?>

                    <?php } ?>
                </select>
            </td>


            <td>
                <input type="text" id="birthDate" placeholder="1972-05-05"
                       value="<?php echo $data['filterbirthDate'] ?>">
            </td>

            <td>
                <input type="text" id="age" placeholder="23" value="<?php echo $data['filterAge'] ?>">
            </td>

            <td>
                <input type="text" class="ages" id="agesFrom" placeholder="13"
                       value="<?php echo $data['filterAgesFrom'] ?>" size="3">
                -
                <input type="text" class="ages" id="agesTo" placeholder="99" value="<?php echo $data['filterAgesTo'] ?>"
                       size="3">
            </td>

        </tr>
        <tr>
            <td colspan="5" align="center">
                <button id="filterButton">filter</button>
            </td>
        </tr>
    </table>
</div>

<div>
    <h4>users <a id="exportButton" class="button" href="<?php echo $data['exportUrl']?>">export</a></h4>
    <table>
        <head>
            <tr>
                <th>id</th>
                <th>category</th>
                <th>firstname</th>
                <th>lastname</th>
                <th>email</th>
                <th>gender</th>
                <th>birthDate</th>
            </tr>
        </head>
        <?php foreach ($data['users'] as $user) { ?>
        <tr>
            <td> <?php echo $user['id'] ?> </td>
            <td> <?php echo $user['category'] ?> </td>
            <td> <?php echo $user['firstname'] ?> </td>
            <td> <?php echo $user['lastname'] ?> </td>
            <td> <?php echo $user['email'] ?> </td>
            <td> <?php echo $user['gender'] ?> </td>
            <td> <?php echo $user['birthDate'] ?> </td>
        </tr>
        <?php } ?>
    </table>
</div>

<div>
    <?php print_r($data['pagination']) ?>
</div>

<script type="text/javascript">
    document.getElementById('filterButton').onclick = function () {
        let redirect = 'index.php?route=users/index';
        if (document.getElementById('category').value !== '') {
            let category = '&category=' + document.getElementById('category').value;
            redirect += category
        }

        if (document.getElementById('gender').value !== '') {
            let gender = '&gender=' + document.getElementById('gender').value;
            redirect += gender
        }

        if (document.getElementById('birthDate').value !== '') {
            let birthDate = '&birthDate=' + document.getElementById('birthDate').value;
            redirect += birthDate
        }

        if (document.getElementById('age').value !== '') {
            let age = '&age=' + document.getElementById('age').value;
            redirect += age
        }

        if (document.getElementById('agesFrom').value !== '0') {
            let agesFrom = '&agesFrom=' + document.getElementById('agesFrom').value;
            redirect += agesFrom;
        }

        if (document.getElementById('agesTo').value !== '1000') {
            let agesTo = '&agesTo=' + document.getElementById('agesTo').value;
            redirect += agesTo
        }
        location = redirect;
    }
</script>

<style>
    table {
        border-collapse: collapse;
        border: 1px solid #000;
    }

    td, th {
        padding: 5px;
        border: 1px solid #000; /* Рамка вокруг ячеек */
    }

    th {
        background: #eaeaea;
    }

    button, .button {
        background: #eaeaea;
        border: 1px solid #666;
        border-radius: 5px;
        padding: 5px 15px;
        cursor: pointer;
        color: #000;
        text-decoration: none
    }

    button:hover, .button:hover {
        background: #cccaca;
    }

    .pagination {
        display: inline-block;
        background: #eaeaea;
        border: 1px solid #666;
        margin: 10px 5px;
        padding: 10px;
        text-decoration: none;
        color: #444040;
    }

    .pagination.active {
        background: #868686;
    }
</style>