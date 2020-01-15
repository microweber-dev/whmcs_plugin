<style>

    .microweber-addon SELECT, INPUT[type="text"] {
        width: 160px;
        box-sizing: border-box;
    }

    .microweber-addon SECTION {
        padding: 8px;
        background-color: #f0f0f0;
        overflow: auto;
    }

    .microweber-addon SECTION > DIV {
        float: left;
        padding: 4px;
    }

    .microweber-addon SECTION > DIV + DIV {
        width: 40px;
        text-align: center;
    }


    .microweber-addon select option[value="aaa"] {
        background-color: powderblue;
    }

    .microweber-addon select option[value="opel"] {
        background-color: red;
    }

    .microweber-addon select option[value="audi"] {
        background-color: green;
    }

    .microweber-addon .template-bg-img {
        display: inline-block;
        height: 40px;
        width: 40px;
        background-repeat: no-repeat;
        background-size: contain;
    }

    .project {
        margin-bottom: 30px;
        vertical-align: top;
        margin-right: 30px;
        float: left;
        cursor: pointer;
        width: 100%;
    }

    .project figure {
        position: relative;
        display: inline-block;
        height: 200px;
        overflow: hidden;
    }

    .project figure img {
        width: 100%;
    }

    .btn-warning bnt-action {
        margin: 0% 0% auto;
    }

    figcaption .project-details {
        display: block;
        font-size: 16px;
        /*line-height: 33px;*/
        color: #000;
        /*height: 27px;*/
        width: 100%;
        margin: 0 auto 5px auto;
        /*margin-bottom: 5px;*/
        overflow: hidden;
    }

    .project figure:hover figcaption {
        background: #d81e05;
    }

    .project figure:hover figcaption .project-details {
        color: #fff;
    }

    figcaption .project-price {
        position: absolute;
        right: 15px;
        top: 12px;
        font-size: 22px;
        text-align: right;
        margin-top: 8px;
        letter-spacing: -1px;
        -webkit-font-smoothing: antialiased;
    }

    figcaption .project-creator {
        font-size: 13px;
        color: #545454;
        display: block;
    }

    figcaption .project-creator {
        font-size: 13px;
        color: #545454;
        display: block;
    }

    .project .actions button {
        padding: 13px 20px;
        font-size: 16px;
        top: 32%;
        position: absolute;
        left: 50%;
        width: 90%;
        margin-left: -45%;
        line-height: 18px;
        letter-spacing: 1px;
    }

    .project figure:hover .actions {
        background-color: rgba(29, 29, 29, 1);
        font-size: 2em;
        font-weight: 700;
    }

    .project .actions {
        display: block;
        position: relative;
        z-index: 1;
        opacity: 1;
        background-color: rgba(29, 29, 29, .9);
        -ms-transition: all .2s ease-out;
        -webkit-transition: all .2s ease-out;
        -moz-transition: all .2s ease-out;
        -o-transition: all .2s ease-out;
        transition: all .2s ease-out;
        color: white;
        font-size: 14px;
        padding: 2px 10px;
        font-weight: bold;
        text-align: center;
    }
</style>
