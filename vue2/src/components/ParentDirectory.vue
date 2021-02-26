<template>
    <div class="go-back">
        <div class="go-back__icon">
            🔙
        </div>
        <div class="go-back__text">
            Назад
        </div>
        <div class="go-back__current">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ParentDirectory"
    }
</script>

<style scoped lang="stylus">
    .go-back
        font-size 20px
        margin-bottom 10px
        display flex
        align-items center
        cursor pointer
        padding-bottom 10px
        border-bottom 1px solid black
        &__icon
            margin-right 10px
            margin-left 10px
        &__current
            font-size 18px
            margin-left 15px
</style>