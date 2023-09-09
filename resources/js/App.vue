<template>
    <div id="nav">
        <ul class="hover-effect">
            <li>
                <router-link to="/">Home</router-link>
            </li>
            <li>
                <router-link to="/create">Create House</router-link>
            </li>
        </ul>
    </div>
    <router-view></router-view>
</template>

<style lang="scss" scoped>
    #nav {
        background-color: aliceblue;
        display: flex;
        column-gap: 20px;
        padding: 20px;

        > ul {
            display: flex;
            column-gap: 20px;
            > li {
                display: inline-block;

                & + li {
                    margin-top: unset;
                }
            }
        }
    }
</style>

