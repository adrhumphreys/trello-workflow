<div id="share-draft-content-message">
    <div class="message">
        <% if $Page.Card.CardUrl %>
            You have been asked to <a target="_blank" href="$Page.Card.CardUrl">provide feedback on this page.</a>
        <% end_if %>
        <br>
        You are viewing the <em>draft state</em> of this page, any page you navigate to will be the <em>published state</em>. <span>How it works.
		<ul class="extra-information">
			<li>Pages appear in two states:</li>
			<li><em>Draft state</em> contains content which is yet to be published. While viewing draft pages, a message will appear to inform you of this.</li>
			<li><em>Published state</em> contains content which has been published. As a result, you will not be notified of this, and will see the live version of the site</li>
		</ul></span>
    </div>
    <div class="share-draft-content-message__action">
        <% if $Page.Card.CardUrl %>
            <a target="_blank" href="$Page.Card.CardUrl">Submit feedback</a>
        <% end_if %>
    </div>
</div>

<style>
    body {
        margin-top: 58px !important;
    }

    #share-draft-content-message {
        display: flex;
        justify-content: center;
        height: 58px !important;
    }

    #share-draft-content-message .message {
        text-align: left;
        margin-right: 30px;
    }

    .share-draft-content-message__action a {
        background-color: blue;
        color: white;
        border: 0;
        border-radius: 3px;
        padding: 5px;
        text-decoration: none;
    }
</style>
