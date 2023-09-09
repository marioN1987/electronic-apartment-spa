<template>
    <div id="nav">
        <router-link to="/">Home</router-link>
        <router-link to="/create">Create</router-link>
    </div>
    <router-view></router-view>
</template>

<style lang="scss" scoped>
    #nav {
        background-color: aliceblue;
        display: flex;
        column-gap: 20px;
        padding: 20px;
        > a {
            text-decoration: none;
            transition: all .3s ease;
            color: black;

            &:hover {
                border-bottom: 1px solid;
            }

            &:active,
            &:focus,
            &:visited {
                color: black;
            }
        }
    }
</style>

