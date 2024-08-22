<?php
defined( 'ABSPATH' ) || die( 'Cheatin\' uh?' );
if ( ! isset( $view ) ) {
	return;
}

/**
 * Rankings Settings view
 *
 * Called from Rankings Controller
 */
?>
<div id="sq_wrap">
	<?php $view->show_view( 'Blocks/Toolbar' ); ?>
	<?php do_action( 'sq_notices' ); ?>
    <div id="sq_content" class="d-flex flex-row bg-white my-0 p-0 m-0">
		<?php
		if ( ! SQ_Classes_Helpers_Tools::userCan( 'sq_manage_focuspages' ) ) {
			echo '<div class="col-12 alert alert-success text-center m-0 p-3">' . esc_html__( "You do not have permission to access this page. You need Squirrly SEO Admin role.", "squirrly-seo" ) . '</div>';

			return;
		}
		?>
		<?php $view->show_view( 'Blocks/Menu' ); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-light m-0 p-0">
            <div class="flex-grow-1 sq_flex m-0 py-0 px-4">
                <form method="POST">
					<?php do_action( 'sq_form_notices' ); ?>
					<?php SQ_Classes_Helpers_Tools::setNonce( 'sq_ranking_settings', 'sq_nonce' ); ?>
                    <input type="hidden" name="action" value="sq_ranking_settings"/>

                    <div class="col-12 p-0 m-0">

                        <div class="sq_breadcrumbs my-4"><?php SQ_Classes_ObjController::getClass( 'SQ_Models_Menu' )->showBreadcrumbs( SQ_Classes_Helpers_Tools::getValue( 'page' ) . '/' . SQ_Classes_Helpers_Tools::getValue( 'tab' ) ) ?></div>
                        <h3 class="mt-4">
							<?php echo esc_html__( "Rankings Settings", "squirrly-seo" ); ?>
                            <div class="sq_help_question d-inline">
                                <a href="https://howto12.squirrly.co/kb/ranking-serp-checker/#ranking_settings" target="_blank"><i class="fa-solid fa-question-circle m-0 p-0"></i></a>
                            </div>
                        </h3>

                        <div id="sq_seosettings" class="col-12 m-0 p-0 border-0">
                            <div class="col-12 m-0 p-0">
                                <div class="col-12 row p-0 m-0 my-5">
                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                        <div class="font-weight-bold"><?php echo esc_html__( "Google Country", "squirrly-seo" ); ?>
                                            :
                                        </div>
                                        <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select the Country for which Squirrly will check the Google rank.", "squirrly-seo" ); ?></div>
                                    </div>
                                    <div class="col-8 p-0 input-group">
                                        <label>
                                            <select name="sq_google_country" class="form-control bg-input mb-1">
                                                <option value="com"><?php echo esc_html__( "Default", "squirrly-seo" ); ?>
                                                    - Globally
                                                </option>
                                                <option value="af"><?php echo "Afghanistan"; ?></option>
                                                <option value="al"><?php echo "Albania"; ?></option>
                                                <option value="dz"><?php echo "Algeria"; ?></option>
                                                <option value="as"><?php echo "American Samoa"; ?></option>
                                                <option value="ad"><?php echo "Andorra"; ?></option>
                                                <option value="ai"><?php echo "Anguilla"; ?></option>
                                                <option value="aq"><?php echo "Antarctica"; ?></option>
                                                <option value="ag"><?php echo "Antigua and Barbuda"; ?></option>
                                                <option value="ar"><?php echo "Argentina"; ?></option>
                                                <option value="am"><?php echo "Armenia"; ?></option>
                                                <option value="aw"><?php echo "Aruba"; ?></option>
                                                <option value="au"><?php echo "Australia"; ?></option>
                                                <option value="at"><?php echo "Austria"; ?></option>
                                                <option value="az"><?php echo "Azerbaijan"; ?></option>

                                                <option value="bs"><?php echo "Bahamas"; ?></option>
                                                <option value="bh"><?php echo "Bahrain"; ?></option>
                                                <option value="bd"><?php echo "Bangladesh"; ?></option>
                                                <option value="bb"><?php echo "Barbados"; ?></option>
                                                <option value="by"><?php echo "Belarus"; ?></option>
                                                <option value="be"><?php echo "Belgium"; ?></option>
                                                <option value="bz"><?php echo "Belize"; ?></option>
                                                <option value="bj"><?php echo "Benin"; ?></option>
                                                <option value="bm"><?php echo "Bermuda"; ?></option>
                                                <option value="bt"><?php echo "Bhutan"; ?></option>
                                                <option value="bo"><?php echo "Bolivia"; ?></option>
                                                <option value="ba"><?php echo "Bosnia and Herzegovina"; ?></option>
                                                <option value="bw"><?php echo "Botswana"; ?></option>
                                                <option value="bv"><?php echo "Bouvet Island"; ?></option>
                                                <option value="br"><?php echo "Brazil"; ?></option>
                                                <option value="io"><?php echo "British Indian Ocean Territory"; ?></option>
                                                <option value="bn"><?php echo "Brunei Darussalam"; ?></option>
                                                <option value="vg"><?php echo "British Virgin Islands"; ?></option>
                                                <option value="bg"><?php echo "Bulgaria"; ?></option>
                                                <option value="bf"><?php echo "Burkina Faso"; ?></option>
                                                <option value="bi"><?php echo "Burundi"; ?></option>

                                                <option value="kh"><?php echo "Cambodia"; ?></option>
                                                <option value="cm"><?php echo "Cameroon"; ?></option>
                                                <option value="ca"><?php echo "Canada"; ?></option>
                                                <option value="cv"><?php echo "Cape Verde"; ?></option>
                                                <option value="ky"><?php echo "Cayman Islands"; ?></option>
                                                <option value="cf"><?php echo "Central African Republic"; ?></option>
                                                <option value="td"><?php echo "Chad"; ?></option>
                                                <option value="cl"><?php echo "Chile"; ?></option>
                                                <option value="cn"><?php echo "China"; ?></option>
                                                <option value="cx"><?php echo "Christmas Island"; ?></option>
                                                <option value="cc"><?php echo "Cocos (Keeling) Islands"; ?></option>
                                                <option value="co"><?php echo "Colombia"; ?></option>
                                                <option value="km"><?php echo "Comoros"; ?></option>
                                                <option value="cg"><?php echo "Congo"; ?></option>
                                                <option value="cd"><?php echo "Dem. Rep. of the Congo"; ?></option>
                                                <option value="ck"><?php echo "Cook Islands"; ?></option>
                                                <option value="cr"><?php echo "Costa Rica"; ?></option>
                                                <option value="ci"><?php echo "Côte d\'Ivoire"; ?></option>
                                                <option value="hr"><?php echo "Croatia"; ?></option>
                                                <option value="cu"><?php echo "Cuba"; ?></option>
                                                <option value="cy"><?php echo "Cyprus"; ?></option>
                                                <option value="cz"><?php echo "Czech Republic"; ?></option>

                                                <option value="dk"><?php echo "Denmark"; ?></option>
                                                <option value="dj"><?php echo "Djibouti"; ?></option>
                                                <option value="dm"><?php echo "Dominica"; ?></option>
                                                <option value="do"><?php echo "Dominican Republic"; ?></option>

                                                <option value="ec"><?php echo "Ecuador"; ?></option>
                                                <option value="eg"><?php echo "Egypt"; ?></option>
                                                <option value="sv"><?php echo "El Salvador"; ?></option>
                                                <option value="gq"><?php echo "Equatorial Guinea"; ?></option>
                                                <option value="er"><?php echo "Eritrea"; ?></option>
                                                <option value="ee"><?php echo "Estonia"; ?></option>
                                                <option value="et"><?php echo "Ethiopia"; ?></option>

                                                <option value="fk"><?php echo "Falkland Islands (Malvinas)"; ?></option>
                                                <option value="fo"><?php echo "Faroe Islands"; ?></option>
                                                <option value="fm"><?php echo "Federated States of Micronesia"; ?></option>
                                                <option value="fj"><?php echo "Fiji"; ?></option>
                                                <option value="fi"><?php echo "Finland"; ?></option>
                                                <option value="fr"><?php echo "France"; ?></option>
                                                <option value="gf"><?php echo "French Guiana"; ?></option>
                                                <option value="pf"><?php echo "French Polynesia"; ?></option>
                                                <option value="tf"><?php echo "French Southern Territories"; ?></option>

                                                <option value="ga"><?php echo "Gabon"; ?></option>
                                                <option value="gm"><?php echo "Gambia"; ?></option>
                                                <option value="ge"><?php echo "Georgia"; ?></option>
                                                <option value="de"><?php echo "Germany"; ?></option>
                                                <option value="gh"><?php echo "Ghana "; ?></option>
                                                <option value="gi"><?php echo "Gibraltar"; ?></option>
                                                <option value="gr"><?php echo "Greece"; ?></option>
                                                <option value="gl"><?php echo "Greenland"; ?></option>
                                                <option value="gd"><?php echo "Grenada"; ?></option>
                                                <option value="gp"><?php echo "Guadeloupe"; ?></option>
                                                <option value="gu"><?php echo "Guam"; ?></option>
                                                <option value="gt"><?php echo "Guatemala"; ?></option>
                                                <option value="gn"><?php echo "Guinea"; ?></option>
                                                <option value="gw"><?php echo "Guinea-Bissau"; ?></option>
                                                <option value="gy"><?php echo "Guyana"; ?></option>

                                                <option value="ht"><?php echo "Haiti"; ?></option>
                                                <option value="hm"><?php echo "Heard Island and Mcdonald Islands"; ?></option>
                                                <option value="va"><?php echo "Holy See (Vatican City State)"; ?></option>
                                                <option value="hn"><?php echo "Honduras"; ?></option>
                                                <option value="hk"><?php echo "Hong Kong"; ?></option>
                                                <option value="hu"><?php echo "Hungary"; ?></option>

                                                <option value="is"><?php echo "Iceland"; ?></option>
                                                <option value="in"><?php echo "India"; ?></option>
                                                <option value="id"><?php echo "Indonesia"; ?></option>
                                                <option value="ir"><?php echo "Iran, Islamic Republic of"; ?></option>
                                                <option value="iq"><?php echo "Iraq"; ?></option>
                                                <option value="ie"><?php echo "Ireland"; ?></option>
                                                <option value="im"><?php echo "Isle of Man"; ?></option>
                                                <option value="il"><?php echo "Israel"; ?></option>
                                                <option value="it"><?php echo "Italy"; ?></option>

                                                <option value="jm"><?php echo "Jamaica"; ?></option>
                                                <option value="jp"><?php echo "Japan"; ?></option>
                                                <option value="je"><?php echo "Jersey"; ?></option>
                                                <option value="kz"><?php echo "Kazakhstan"; ?></option>
                                                <option value="ke"><?php echo "Kenya"; ?></option>
                                                <option value="ki"><?php echo "Kiribati"; ?></option>
                                                <option value="kp"><?php echo "Korea, Democratic People\'s Republic of"; ?></option>
                                                <option value="kr"><?php echo "Korea, Republic of"; ?></option>
                                                <option value="kw"><?php echo "Kuwait"; ?></option>
                                                <option value="kg"><?php echo "Kyrgyzstan"; ?></option>

                                                <option value="la"><?php echo "Lao People\'s Democratic Republic"; ?></option>
                                                <option value="lv"><?php echo "Latvia"; ?></option>
                                                <option value="lb"><?php echo "Lebanon"; ?></option>
                                                <option value="ls"><?php echo "Lesotho"; ?></option>
                                                <option value="lr"><?php echo "Liberia"; ?></option>
                                                <option value="ly"><?php echo "Libyan Arab Jamahiriya"; ?></option>
                                                <option value="li"><?php echo "Liechtenstein"; ?></option>
                                                <option value="lt"><?php echo "Lithuania"; ?></option>
                                                <option value="lu"><?php echo "Luxembourg"; ?></option>

                                                <option value="mo"><?php echo "Macao"; ?></option>
                                                <option value="mk"><?php echo "Macedonia"; ?></option>
                                                <option value="mg"><?php echo "Madagascar"; ?></option>
                                                <option value="mw"><?php echo "Malawi"; ?></option>
                                                <option value="my"><?php echo "Malaysia"; ?></option>
                                                <option value="mv"><?php echo "Maldives"; ?></option>
                                                <option value="ml"><?php echo "Mali"; ?></option>
                                                <option value="mt"><?php echo "Malta"; ?></option>
                                                <option value="mh"><?php echo "Marshall Islands"; ?></option>
                                                <option value="mq"><?php echo "Martinique"; ?></option>
                                                <option value="mr"><?php echo "Mauritania"; ?></option>
                                                <option value="mu"><?php echo "Mauritius"; ?></option>
                                                <option value="yt"><?php echo "Mayotte"; ?></option>
                                                <option value="mx"><?php echo "México"; ?></option>
                                                <option value="fm"><?php echo "Micronesia"; ?></option>
                                                <option value="md"><?php echo "Moldova"; ?></option>
                                                <option value="mc"><?php echo "Monaco"; ?></option>
                                                <option value="mn"><?php echo "Mongolia"; ?></option>
                                                <option value="ms"><?php echo "Montserrat"; ?></option>
                                                <option value="ma"><?php echo "Morocco"; ?></option>
                                                <option value="mz"><?php echo "Mozambique"; ?></option>
                                                <option value="mm"><?php echo "Myanmar"; ?></option>

                                                <option value="na"><?php echo "Namibia"; ?></option>
                                                <option value="nr"><?php echo "Nauru"; ?></option>
                                                <option value="np"><?php echo "Nepal"; ?></option>
                                                <option value="nl"><?php echo "Netherlands"; ?></option>
                                                <option value="an"><?php echo "Netherlands Antilles"; ?></option>
                                                <option value="nc"><?php echo "New Caledonia"; ?></option>
                                                <option value="nz"><?php echo "New Zealand"; ?></option>
                                                <option value="ni"><?php echo "Nicaragua"; ?></option>
                                                <option value="ne"><?php echo "Niger"; ?></option>
                                                <option value="ng"><?php echo "Nigeria"; ?></option>
                                                <option value="nu"><?php echo "Niue"; ?></option>
                                                <option value="nf"><?php echo "Norfolk Island"; ?></option>
                                                <option value="mp"><?php echo "Northern Mariana Islands"; ?></option>
                                                <option value="no"><?php echo "Norway"; ?></option>
                                                <option value="om"><?php echo "Oman"; ?></option>

                                                <option value="pk"><?php echo "Pakistan"; ?></option>
                                                <option value="pw"><?php echo "Palau"; ?></option>
                                                <option value="ps"><?php echo "Palestinian Territory"; ?></option>
                                                <option value="pa"><?php echo "Panamá"; ?></option>
                                                <option value="pg"><?php echo "Papua New Guinea"; ?></option>
                                                <option value="py"><?php echo "Paraguay"; ?></option>
                                                <option value="pe"><?php echo "Perú"; ?></option>
                                                <option value="ph"><?php echo "Philippines"; ?></option>
                                                <option value="pn"><?php echo "Pitcairn Islands"; ?></option>
                                                <option value="pl"><?php echo "Poland"; ?></option>
                                                <option value="pt"><?php echo "Portugal"; ?></option>
                                                <option value="pr"><?php echo "Puerto Rico"; ?></option>
                                                <option value="qa"><?php echo "Qatar"; ?></option>

                                                <option value="re"><?php echo "Reunion"; ?></option>
                                                <option value="ro"><?php echo "Romania"; ?></option>
                                                <option value="ru"><?php echo "Russia"; ?></option>
                                                <option value="rw"><?php echo "Rwanda"; ?></option>

                                                <option value="sh"><?php echo "Saint Helena"; ?></option>
                                                <option value="kn"><?php echo "Saint Kitts and Nevis"; ?></option>
                                                <option value="lc"><?php echo "Saint Lucia"; ?></option>
                                                <option value="pm"><?php echo "Saint Pierre and Miquelon"; ?></option>
                                                <option value="vc"><?php echo "Saint Vincent and the Grenadines"; ?></option>
                                                <option value="ws"><?php echo "Samoa"; ?></option>
                                                <option value="sm"><?php echo "San Marino"; ?></option>
                                                <option value="st"><?php echo "Sao Tome and Principe"; ?></option>
                                                <option value="sa"><?php echo "Saudi Arabia"; ?></option>
                                                <option value="sn"><?php echo "Senegal"; ?></option>
                                                <option value="rs"><?php echo "Serbia and Montenegro"; ?></option>
                                                <option value="sc"><?php echo "Seychelles"; ?></option>
                                                <option value="sl"><?php echo "Sierra Leone"; ?></option>
                                                <option value="sg"><?php echo "Singapore"; ?></option>
                                                <option value="sk"><?php echo "Slovakia"; ?></option>
                                                <option value="si"><?php echo "Slovenia"; ?></option>
                                                <option value="sb"><?php echo "Solomon Islands"; ?></option>
                                                <option value="so"><?php echo "Somalia"; ?></option>
                                                <option value="za"><?php echo "South Africa"; ?></option>
                                                <option value="gs"><?php echo "South Georgia and the South Sandwich Islands"; ?></option>
                                                <option value="es"><?php echo "Spain"; ?></option>
                                                <option value="lk"><?php echo "Sri Lanka"; ?></option>
                                                <option value="sd"><?php echo "Sudan"; ?></option>
                                                <option value="sr"><?php echo "Suriname"; ?></option>
                                                <option value="sj"><?php echo "Svalbard and Jan Mayen"; ?></option>
                                                <option value="sz"><?php echo "Swaziland"; ?></option>
                                                <option value="se"><?php echo "Sweden"; ?></option>
                                                <option value="ch"><?php echo "Switzerland"; ?></option>
                                                <option value="sy"><?php echo "Syrian Arab Republic"; ?></option>

                                                <option value="tw"><?php echo "Taiwan"; ?></option>
                                                <option value="tj"><?php echo "Tajikistan"; ?></option>
                                                <option value="tz"><?php echo "Tanzania, United Republic of"; ?></option>
                                                <option value="th"><?php echo "Thailand"; ?></option>
                                                <option value="tl"><?php echo "Timor-Leste"; ?></option>
                                                <option value="tg"><?php echo "Togo"; ?></option>
                                                <option value="tk"><?php echo "Tokelau"; ?></option>
                                                <option value="to"><?php echo "Tonga"; ?></option>
                                                <option value="tt"><?php echo "Trinidad and Tobago"; ?></option>
                                                <option value="tn"><?php echo "Tunisia"; ?></option>
                                                <option value="tr"><?php echo "Turkey"; ?></option>
                                                <option value="tm"><?php echo "Turkmenistan"; ?></option>
                                                <option value="tc"><?php echo "Turks and Caicos Islands"; ?></option>
                                                <option value="tv"><?php echo "Tuvalu"; ?></option>

                                                <option value="ug"><?php echo "Uganda"; ?></option>
                                                <option value="ua"><?php echo "Ukraine"; ?></option>
                                                <option value="ae"><?php echo "United Arab Emirates"; ?></option>
                                                <option value="uk"><?php echo "United Kingdom"; ?></option>
                                                <option value="us"><?php echo "United States"; ?></option>
                                                <option value="um"><?php echo "United States Minor Outlying Islands"; ?></option>
                                                <option value="uy"><?php echo "Uruguay"; ?></option>
                                                <option value="uz"><?php echo "Uzbekistan"; ?></option>

                                                <option value="vu"><?php echo "Vanuatu"; ?></option>
                                                <option value="ve"><?php echo "Venezuela"; ?></option>
                                                <option value="vn"><?php echo "Vietnam"; ?></option>
                                                <option value="vg"><?php echo "Virgin Islands, British"; ?></option>
                                                <option value="vi"><?php echo "Virgin Islands, U.S."; ?></option>

                                                <option value="wf"><?php echo "Wallis and Futuna"; ?></option>
                                                <option value="eh"><?php echo "Western Sahara"; ?></option>
                                                <option value="ye"><?php echo "Yemen"; ?></option>

                                                <option value="zm"><?php echo "Zambia"; ?></option>
                                                <option value="zw"><?php echo "Zimbabwe"; ?></option>
                                            </select>
                                        </label>
                                        <script>jQuery('select[name=sq_google_country]').val('<?php echo esc_attr( str_replace( array(
												'com.',
												'co.'
											), '', SQ_Classes_Helpers_Tools::getOption( 'sq_google_country' ) ) )?>').attr('selected', true);</script>

                                    </div>
                                </div>

                                <div class="col-12 row p-0 m-0 my-5">
                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                        <div class="font-weight-bold"><?php echo esc_html__( "Google Language", "squirrly-seo" ); ?>
                                            :
                                        </div>
                                        <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select the Language for which Squirrly will check the Google rank.", "squirrly-seo" ); ?></div>
                                    </div>
                                    <div class="col-8 p-0 input-group">
                                        <label>
                                            <select name="sq_google_language" class="form-control bg-input mb-1">
                                                <option value="af">Afrikaans</option>
                                                <option value="ak">Akan</option>
                                                <option value="sq">Albanian - shqip</option>
                                                <option value="am">Amharic - አማርኛ</option>
                                                <option value="ar">Arabic - العربية</option>
                                                <option value="an">Aragonese - aragonés</option>
                                                <option value="hy">Armenian - հայերեն</option>
                                                <option value="ast">Asturian - asturianu</option>
                                                <option value="az">Azerbaijani - azərbaycan dili</option>
                                                <option value="eu">Basque - euskara</option>
                                                <option value="be">Belarusian - беларуская</option>
                                                <option value="bem">Bemba</option>
                                                <option value="bn">Bengali - বাংলা</option>
                                                <option value="bh">Bihari</option>
                                                <option value="bs">Bosnian - bosanski</option>
                                                <option value="br">Breton - brezhoneg</option>
                                                <option value="bg">Bulgarian - български</option>
                                                <option value="km">Cambodian</option>
                                                <option value="ca">Catalan - català</option>
                                                <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
                                                <option value="chr">Cherokee</option>
                                                <option value="ny">Chichewa</option>
                                                <option value="zh">Chinese - 中文</option>
                                                <option value="zh_HK">Chinese (Hong Kong) - 中文（香港）</option>
                                                <option value="zh_CN">Chinese (Simplified) - 中文（简体）</option>
                                                <option value="zh_TW">Chinese (Traditional) - 中文（繁體）</option>
                                                <option value="co">Corsican</option>
                                                <option value="hr">Croatian - hrvatski</option>
                                                <option value="cs">Czech - čeština</option>
                                                <option value="da">Danish - dansk</option>
                                                <option value="nl">Dutch - Nederlands</option>
                                                <option value="en">English</option>
                                                <option value="en_AU">English (Australia)</option>
                                                <option value="en_CA">English (Canada)</option>
                                                <option value="en_IN">English (India)</option>
                                                <option value="en_NZ">English (New Zealand)</option>
                                                <option value="en_ZA">English (South Africa)</option>
                                                <option value="en_GB">English (United Kingdom)</option>
                                                <option value="en_US">English (United States)</option>
                                                <option value="eo">Esperanto - esperanto</option>
                                                <option value="et">Estonian - eesti</option>
                                                <option value="ee">Ewe</option>
                                                <option value="fo">Faroese - føroyskt</option>
                                                <option value="tl">Filipino</option>
                                                <option value="fi">Finnish - suomi</option>
                                                <option value="fr">French - français</option>
                                                <option value="fr_CA">French (Canada) - français (Canada)</option>
                                                <option value="fr_FR">French (France) - français (France)</option>
                                                <option value="fr_CH">French (Switzerland) - français (Suisse)</option>
                                                <option value="gl">Galician - galego</option>
                                                <option value="ka">Georgian - ქართული</option>
                                                <option value="de">German - Deutsch</option>
                                                <option value="de_AT">German (Austria) - Deutsch (Österreich)</option>
                                                <option value="de_DE">German (Germany) - Deutsch (Deutschland)</option>
                                                <option value="de_LI">German (Liechtenstein) - Deutsch (Liechtenstein)
                                                </option>
                                                <option value="de_CH">German (Switzerland) - Deutsch (Schweiz)</option>
                                                <option value="el">Greek - Ελληνικά</option>
                                                <option value="gn">Guarani</option>
                                                <option value="gu">Gujarati - ગુજરાતી</option>
                                                <option value="ha">Hausa</option>
                                                <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
                                                <option value="iw">Hebrew - עברית</option>
                                                <option value="hi">Hindi - हिन्दी</option>
                                                <option value="hu">Hungarian - magyar</option>
                                                <option value="is">Icelandic - íslenska</option>
                                                <option value="id">Indonesian - Indonesia</option>
                                                <option value="ia">Interlingua</option>
                                                <option value="ga">Irish - Gaeilge</option>
                                                <option value="it">Italian - italiano</option>
                                                <option value="it_IT">Italian (Italy) - italiano (Italia)</option>
                                                <option value="it_CH">Italian (Switzerland) - italiano (Svizzera)
                                                </option>
                                                <option value="ja">Japanese - 日本語</option>
                                                <option value="jw">Javanese</option>
                                                <option value="kn">Kannada - ಕನ್ನಡ</option>
                                                <option value="kk">Kazakh - қазақ тілі</option>
                                                <option value="rw">Kinyarwanda</option>
                                                <option value="rn">Kirundi</option>
                                                <option value="km">Khmer - ខ្មែរ</option>
                                                <option value="kg">Kongo</option>
                                                <option value="ko">Korean - 한국어</option>
                                                <option value="ku">Kurdish - Kurdî</option>
                                                <option value="ky">Kyrgyz - кыргызча</option>
                                                <option value="lo">Lao - ລາວ</option>
                                                <option value="la">Latin</option>
                                                <option value="lv">Latvian - latviešu</option>
                                                <option value="ln">Lingala - lingála</option>
                                                <option value="lt">Lithuanian - lietuvių</option>
                                                <option value="loz">Lozi</option>
                                                <option value="lg">Luganda</option>
                                                <option value="mk">Macedonian - македонски</option>
                                                <option value="mg">Malagasy</option>
                                                <option value="ms">Malay - Bahasa Melayu</option>
                                                <option value="ml">Malayalam - മലയാളം</option>
                                                <option value="mt">Maltese - Malti</option>
                                                <option value="mi">Maori</option>
                                                <option value="mr">Marathi - मराठी</option>
                                                <option value="mfe">Mauritian Creole</option>
                                                <option value="mo">Moldavian</option>
                                                <option value="mn">Mongolian - монгол</option>
                                                <option value="ne">Nepali - नेपाली</option>
                                                <option value="pcm">Nigerian Pidgin</option>
                                                <option value="nso">Northern Sotho</option>
                                                <option value="no">Norwegian - norsk</option>
                                                <option value="nb">Norwegian Bokmål - norsk bokmål</option>
                                                <option value="nn">Norwegian Nynorsk - nynorsk</option>
                                                <option value="oc">Occitan</option>
                                                <option value="or">Oriya - ଓଡ଼ିଆ</option>
                                                <option value="om">Oromo - Oromoo</option>
                                                <option value="ps">Pashto - پښتو</option>
                                                <option value="fa">Persian - فارسی</option>
                                                <option value="pl">Polish - polski</option>
                                                <option value="pt">Portuguese - português</option>
                                                <option value="pt_BR">Portuguese (Brazil) - português (Brasil)</option>
                                                <option value="pt_PT">Portuguese (Portugal) - português (Portugal)
                                                </option>
                                                <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
                                                <option value="qu">Quechua</option>
                                                <option value="ro">Romanian - română</option>
                                                <option value="mo">Romanian (Moldova) - română (Moldova)</option>
                                                <option value="rm">Romansh - rumantsch</option>
                                                <option value="ru">Russian - русский</option>
                                                <option value="gd">Scottish Gaelic</option>
                                                <option value="sr">Serbian - српски</option>
                                                <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
                                                <option value="st">Sesotho</option>
                                                <option value="tn">Setswana</option>
                                                <option value="crs">Seychellois Creole</option>
                                                <option value="sn">Shona - chiShona</option>
                                                <option value="sd">Sindhi</option>
                                                <option value="si">Sinhala - සිංහල</option>
                                                <option value="sk">Slovak - slovenčina</option>
                                                <option value="sl">Slovenian - slovenščina</option>
                                                <option value="so">Somali - Soomaali</option>
                                                <option value="st">Southern Sotho</option>
                                                <option value="es">Spanish - español</option>
                                                <option value="es_AR">Spanish (Argentina) - español (Argentina)</option>
                                                <option value="es_419">Spanish (Latin America) - español
                                                    (Latinoamérica)
                                                </option>
                                                <option value="es_MX">Spanish (Mexico) - español (México)</option>
                                                <option value="es_ES">Spanish (Spain) - español (España)</option>
                                                <option value="es_US">Spanish (United States) - español (Estados
                                                    Unidos)
                                                </option>
                                                <option value="su">Sundanese</option>
                                                <option value="sw">Swahili - Kiswahili</option>
                                                <option value="sv">Swedish - svenska</option>
                                                <option value="tg">Tajik - тоҷикӣ</option>
                                                <option value="ta">Tamil - தமிழ்</option>
                                                <option value="tt">Tatar</option>
                                                <option value="te">Telugu - తెలుగు</option>
                                                <option value="th">Thai - ไทย</option>
                                                <option value="ti">Tigrinya - ትግርኛ</option>
                                                <option value="to">Tongan - lea fakatonga</option>
                                                <option value="lua">Tshiluba</option>
                                                <option value="tum">Tumbuka</option>
                                                <option value="tr">Turkish - Türkçe</option>
                                                <option value="tk">Turkmen</option>
                                                <option value="tw">Twi</option>
                                                <option value="uk">Ukrainian - українська</option>
                                                <option value="ur">Urdu - اردو</option>
                                                <option value="ug">Uyghur</option>
                                                <option value="uz">Uzbek - o‘zbek</option>
                                                <option value="vi">Vietnamese - Tiếng Việt</option>
                                                <option value="wa">Walloon - wa</option>
                                                <option value="cy">Welsh - Cymraeg</option>
                                                <option value="fy">Western Frisian</option>
                                                <option value="wo">Wolof</option>
                                                <option value="xh">Xhosa</option>
                                                <option value="yi">Yiddish</option>
                                                <option value="yo">Yoruba - Èdè Yorùbá</option>
                                                <option value="zu">Zulu - isiZulu</option>
                                            </select>
                                        </label>
                                        <script>jQuery('select[name=sq_google_language]').val('<?php echo esc_attr( SQ_Classes_Helpers_Tools::getOption( 'sq_google_language' ) )?>').attr('selected', true);</script>

                                    </div>
                                </div>

                                <div class="col-12 row p-0 m-0 my-5">
                                    <div class="col-4 p-0 pr-3 font-weight-bold">
                                        <div class="font-weight-bold"><?php echo esc_html__( "Device", "squirrly-seo" ); ?>
                                            :
                                        </div>
                                        <div class="small text-black-50 my-1 pr-3"><?php echo esc_html__( "Select the Device for which Squirrly will check the Google rank.", "squirrly-seo" ); ?></div>
                                    </div>
                                    <div class="col-8 p-0 input-group">
                                        <label>
                                            <select name="sq_google_device" class="form-control bg-input mb-1">
                                                <option value="desktop">Desktop</option>
                                                <option value="tablet">Tablet</option>
                                                <option value="mobile">Mobile</option>
                                            </select>
                                        </label>
                                        <script>jQuery('select[name=sq_google_device]').val('<?php echo esc_attr( SQ_Classes_Helpers_Tools::getOption( 'sq_google_device' ) )?>').attr('selected', true);</script>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

					<?php do_action( 'sq_rankings_settings_after' ); ?>

                    <div class="col-12 m-0 p-0">
                        <button type="submit" class="btn rounded-0 btn-primary btn-lg py-2 px-5"><?php echo esc_html__( "Save Settings", "squirrly-seo" ); ?></button>
                    </div>
                </form>

                <div class="sq_tips col-12 m-0 p-0 my-5">
                    <h5 class="text-left my-3 font-weight-bold">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo esc_html__( "Tips and Tricks", "squirrly-seo" ); ?>
                    </h5>
                    <ul class="mx-4 my-1">
                        <li class="text-left small"><?php echo esc_html__( "Complete the Mastery Tasks you see on the right side of your screen to make the most out of the Rankings section of Squirrly SEO.", "squirrly-seo" ); ?></li>
                        <li class="text-left small"><?php echo esc_html__( "Follow the instructions to mark every task as Completed.", "squirrly-seo" ); ?></li>
                    </ul>
                </div>

				<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockKnowledgeBase' )->init(); ?>

            </div>
            <div class="sq_col_side bg-white">
                <div class="col-12 m-0 p-0 sq_sticky">
					<?php SQ_Classes_ObjController::getClass( 'SQ_Core_BlockAssistant' )->init(); ?>

					<?php do_action( 'sq_rankings_settings_side_after' ); ?>

                </div>
            </div>
        </div>

    </div>
</div>
