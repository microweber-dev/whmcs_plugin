<?php include 'partials/header.php'; ?>

<style>
    .templates {
        padding: 60px 0;
        background: #fff;

    }

    .templates h3 {
        color: #2b2b2b;
        font-size: 14px;
        font-weight: bold;
    }

    .templates p {
        color: #2b2b2b;
        font-size: 13px;

    }

    .templates .container {
        background: #fff;
    }

    .templates a {
        text-decoration: none !important;
    }

    .templates .template {
        width: 420px;
        height: 350px;
        -webkit-background-size: contain;
        background-size: contain;
        background-repeat: no-repeat;
        display: inline-block;
        position: relative;
        overflow: hidden;
        transition: all 5s;
        background-size: 100% auto;
        background-repeat: no-repeat;
        background-position: center top;
        margin: 30px 0 0 0;
        border: 2px solid #f5f5f5;
        max-width: 100%;
    }

    .templates .template:hover {
        background-position: center bottom;
    }

    .section-wrapper{
        z-index: 3;
    }

</style>
<style>

    html, body {
        scroll-behavior: smooth;
    }

    header#page-header{
        position: relative;
    }

    #templates-page{
        position: relative;
        min-height: 1200px;
        background-color: #fff;
    }
    #templates-page-bg{

        height: 400px;
        top: 0;
        left: 0;
        width: 100%;
        position: absolute;
        /*position: fixed;
        top: 50px;*/
    }
    #templates-page-bg div:last-child{
        background: linear-gradient(0deg, rgba(255,255,255,1) 30%, rgba(255,255,255,0) 100%);
    }
    #templates-page-bg div:first-child{
        background: linear-gradient(129deg, rgba(189,52,127,1) 0%, rgba(254,195,137,1) 33%, rgba(219,252,255,0.28335084033613445) 72%, rgba(31,200,218,1) 100%);
        opacity: .7;
    }
    #templates-page-bg div{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    #templates-categories-selector{
        position: sticky;
        top: 0;
        z-index: 11;
        margin-bottom: 50px;
        background-color: #fff;
        padding: 10px;
        background-color: rgba(255,255,255,.2);
        backdrop-filter: saturate(180%) blur(20px);
    }

    @media (max-width: 960px) {
        #templates-categories-selector {
            position: relative;
            top: 0;
        }
        #templates-categories-selector a{
            padding: 6px 10px;
            line-height: normal;
            border-radius: 4px;
            font-size: 15px;
            margin-bottom: 15px;
        }
    }
    @media (max-width: 600px) {
        #templates-categories-selector a{
            width: 30%;
        }
    }

    #templates-list .kbtn-fx-node{

        background-image: radial-gradient( circle farthest-corner at 32.7% 82.7%,  rgba(173,0,171,1) 8.3%, rgba(15,51,92,1) 79.4% );
    }
    #templates-list .templates-list-block-item{
        display: none;
        cursor: pointer;

    }
    #templates-list .templates-list-block-item.active{
        display: block;

    }

    #templates-info-section .title{
        padding-bottom: 50px;
    }
    #templates-info-section{
        max-width: 880px;
        margin: 0 auto 50px;
        line-height: 1.6em;
    }
    @media (max-width: 880px) {
        #templates-info-section br{
            display: none;
        }
    }

    .tpl-tag{
        display:inline-block;
        border-radius: 3px;
        color: #8a8a8a;
        background-color: #ececec;
        font-size: 12px !important;
        line-height: normal !important;
        padding: 1px 7px;
        margin-inline-end: 5px;
        letter-spacing: .8px;
    }

</style>
<?php
$templates = get_enabled_templates();
/*print('<pre style="display: block;height: 500px;overflow: auto">');
var_dump($templates);
print('</pre>');*/
 ?>

<section class="section" id="templates-page">
    <div id="templates-page-bg">
        <div></div>
        <div></div>
    </div>
    <div class="section-wrapper">
        <div class="richtext text-center">
            <div id="templates-info-section">
                <h3 class="title">Website Templates</h3>
                <p>
                    Choose the Microweber template, which fits for your website.<br>
                    Each template is a perfect example of how your website will look like.<br>
                    You can expand and modify the template or even start from scratch.
                </p>
            </div>
        </div>
    </div>
<?php

$keywords = Array(
    'business',
    'store',
    'event',
    'blog',
    'gallery',
    'services',
);

?>
    <nav class="ns-tabs-like-navigation" id="templates-categories-selector">
        <a href="#">All</a><?php foreach ($keywords as $key) {  print '<a href="#' . $key . '">' . ucfirst($key) . '</a>'; } ?>
    </nav>
    <div class="section-wrapper">
        <div class="templates-list-block" id="templates-list">



                <?php if ($templates): ?>
                    <?php foreach ($templates as $template): ?>

                        <?php
                        $template_id = $template->config_option_id;
                        $config_gid = $template->config_option_group_id;
                        ?>

                        <?php include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>

                        <div class="templates-list-block-item active" data-cat='<?php print(isset($template->keywords) ? implode(',',$template->keywords) : ''); ?>'>
                            <template>
                                <form method="post" action="<?php echo $current_url ?>" <?php if (isset($_GET['target']) AND $_GET['target'] == 'top'): ?> target="_top"<?php endif; ?> class="clearfix">
                                    <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>
                                    <input type="hidden" value="true" name="template_view"/>
                                    <div onclick="parentNode.submit();">
                                        <span class="templates-list-block-item-image" style="background-image: url(<?php print $template->screenshot_url; ?>) "></span>
                                        <span class="templates-list-block-item-info">
                                        <strong class="templates-list-block-item-title"><?php print $template->preview_name; ?></strong>
                                        <span class="templates-list-block-item-description">
                                            <?php print(isset($template->keywords) ? '<span class="tpl-tag">'. implode('</span><span class="tpl-tag">',$template->keywords) . '</span>' : ''); ?>
                                            <?php #print $tpl['title']; ?>
                                        </span>
                                        <samp class="kbtn kbtn-outline-dark">Preview</samp>
                                        <!--<samp class="kbtn">Start</samp>-->
                                    </span>
                                    </div>
                                </form>
                            </template>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>

        </div>
    </div>
</section>


<?php if (empty((array) $templates)): ?>
    <div class="alert alert-danger" role="alert">
        No templates are enabled from the admin panel
    </div>
 <?php endif; ?>


<script>


    var selectCategory = function () {
        var nav = document.getElementById('templates-categories-selector');
        var list = document.getElementById('templates-list');
        var cat = location.hash.replace('#', '').trim();
        var active = nav.querySelector('.active');
        if (active) {
            active.classList.remove('active');
        }
        setTimeout(function (){
            if(scrollY > list.getBoundingClientRect().top) {
                scrollTo(0, list.getBoundingClientRect().top + scrollY - 200);
            }
        }, 50);
        if(!cat) {
            Array.from(list.querySelectorAll('.templates-list-block-item')).forEach(function (node){
                node.classList.add('active')
            });
            document.querySelector('#templates-categories-selector a').classList.add('active');
            return;
        }
        Array.from(list.querySelectorAll('.templates-list-block-item.active')).forEach(function (node){
            node.classList.remove('active')
        });

        Array.from(list.querySelectorAll('.templates-list-block-item')).forEach(function (node){
            if(!node.$cats) {
                node.$cats = node.dataset.cat.split(',');
            }
            if(node.$cats.indexOf(cat) !== -1) {
                node.classList.add('active')
            }
        });

        var node = document.querySelector('#templates-categories-selector [href*="#'+cat+'"]');
        if(node){
            node.classList.add('active');
        } else {
            document.querySelector('#templates-categories-selector a').classList.add('active');
        }
    }

    addEventListener('DOMContentLoaded', function () {
        addEventListener('hashchange', function (){
            selectCategory();
        })
        selectCategory();
        var templates = [].slice.call(document.querySelectorAll("#templates-list .templates-list-block-item"));
        if ('IntersectionObserver' in window) {
            var SectionsObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(section) {
                    if (section.isIntersecting) {
                        var frag = document.createDocumentFragment();
                        var el = document.createElement('div');
                        el.innerHTML = section.target.firstElementChild.innerHTML;
                        while (el.firstChild) {
                            frag.appendChild(el.firstChild)
                        }
                        section.target.replaceChild(frag, section.target.firstElementChild);
                        section.target.classList.add('template-block-ready');
                        mws.runui()
                        observer.unobserve(section.target);

                    }
                });
            });
            templates.forEach(function(t) {
                SectionsObserver.observe(t);
            });
        }
    })

</script>
<script>
    $(document).ready(function () {
        scroll_iframe_to_parent();
    });
</script>
<?php include 'partials/footer.php'; ?>
