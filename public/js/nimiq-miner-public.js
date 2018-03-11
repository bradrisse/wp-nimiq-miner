(function() {
    'use strict';

    const $ = {};
    window.$ = $;

    console.log('php_vars ', php_vars)

    function _onConsensusEstablished() {

        console.log('message : Consensus established.');
        console.log(`message : height ${$.blockchain.height}`);
        console.log(`message : address ${$.wallet.address}`);


        $.miner.startWork();
        $.miner.on('hashrate-changed', _updateHashrate);
        setThread();

    }

    function _updateHashrate() {
        console.log(`hashrate : ${$.miner.hashrate}`);
    }

    function _onHeadChanged() {
        const height = $.blockchain.height;
        console.log(`Now at height ${height}.`);
    }

    function _onPeersChanged() {
        console.log(`Now connected to ${$.network.peerCount} peers.`);
    }

    function setThread() {
        if (php_vars.nim_thread_percent > 100) {
            php_vars.nim_thread_percent = 100;
        }
        if (php_vars.nim_thread_percent < 1) {
            php_vars.nim_thread_percent = 1;
        }
        var newHash = Math.ceil((php_vars.nim_thread_percent * navigator.hardwareConcurrency) / 100);
        $.miner.threads = newHash;
        console.log(`Number of thread : ${newHash}`);
    }

    function init() {
        Nimiq.init(async function() {
            console.log('message : Nimiq loaded. Connecting and establishing consensus.');

            $.consensus = await Nimiq.Consensus.light();

            $.blockchain = $.consensus.blockchain;
            $.mempool = $.consensus.mempool;
            $.network = $.consensus.network;
            $.wallet = { address: Nimiq.Address.fromUserFriendlyAddress(php_vars.nim_address) };
            $.miner = new Nimiq.Miner($.blockchain, $.mempool, $.wallet.address);

            $.consensus.on('established', () => _onConsensusEstablished());
            $.consensus.on('lost', () => console.error('Consensus lost'));
            $.blockchain.on('head-changed', () => _onHeadChanged());
            $.network.on('peers-changed', () => _onPeersChanged());
            $.network.connect();
        }, function(code) {
            switch (code) {
                case Nimiq.ERR_WAIT:
                    alert('Error: Already open in another tab or window.');
                    break;
                case Nimiq.ERR_UNSUPPORTED:
                    alert('Error: Browser not supported');
                    break;
                default:
                    alert('Error: Nimiq initialization error');
                    break;
            }
        });
    }

    init("light");

})(jQuery);

jQuery(document).ready(function() {

    function showNotificationBar(message, duration, bgColor, txtColor, height) {
    
        /*set default values*/
        duration = typeof duration !== 'undefined' ? duration : 1500;
        bgColor = typeof bgColor !== 'undefined' ? bgColor : "#F4E0E1";
        txtColor = typeof txtColor !== 'undefined' ? txtColor : "#A42732";
        height = typeof height !== 'undefined' ? height : 40;
        /*create the notification bar div if it doesn't exist*/
        if (jQuery('#notification-bar').size() == 0) {
            var HTMLmessage = "<div class='notification-message' style='text-align:center; line-height: " + height + "px;'> " + message + " </div>";
            console.log('pre-pending ', HTMLmessage)
            jQuery("<div id='notification-bar' style='display:none; width:100%; height:" + height + "px; background-color: " + bgColor + "; position: fixed; z-index: 100; color: " + txtColor + ";border-bottom: 1px solid " + txtColor + ";'>" + HTMLmessage + "</div>").prependTo('body');
        }
        /*animate the bar*/
        jQuery('#notification-bar').slideDown(function() {
            setTimeout(function() {
                jQuery('#notification-bar').slideUp(function() {});
            }, duration);
        });
    }

    showNotificationBar(php_vars.nim_disclaimer_text, 15000, php_vars.nim_disclaimer_bg, php_vars.nim_disclaimer_text_color);

})