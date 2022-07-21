<template>
<div class="login-form">
    <form action="/login" method="POST">
        <label for="name">名字：</label>
        <input type="text" name="name"><br>
        <label for="email">email: </label>
        <input type="text" name="email"><br>
        <label for="password">密碼：</label>
        <input type="text" name="password"><br>
        <input type="submit" value="登入">
    </form>
</div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
