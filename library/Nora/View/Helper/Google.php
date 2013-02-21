<?php
namespace Nora\View\Helper;

/**
 * ヘルパー: Doctype
 */
class Google extends Placeholder
{
	/** ダイレクトメソッド */
	public function Google( )
	{
		if( $email != null )
		{
			$this->setEmeil( $email );
		}
		return $this;
	}

	public function __construct( )
	{
		$this->placeholder('analytics')->setFormat(<<<EOF
<!-- Google Analytics //-->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '%s']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<!-- /Google Analytics //-->
EOF
	);
	}

	public function analytics( $ua = null )
	{
		if( $ua !== null)
		{
			return $this->placeholder('analytics')->append($ua);
		}
		else
		{
			return $this->placeholder('analytics');
		}
	}
}
