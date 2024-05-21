{**
 * BINSHOPS REST API
 *
 * @author BINSHOPS
 * @copyright BINSHOPS
 *
 *}

<div class="panel">
    <h3><i class="icon icon-credit-card"></i> {l s='PrestaShop REST API Free version' mod='binshopsrest'}</h3>
    <p>
        <strong>{l s='Your endpoints are ready!' mod='binshopsrest'}</strong><br />
        {l s='There is no configuration required for this module out of the box. Your endpoint: https://example.com/rest/{endpoint}'
        mod='binshopsrest'}
    </p>

    <a href="https://addons.prestashop.com/en/website-performance/52062-rest-api-pro-version-with-fast-api-caching.html"
        target="_blank">
        <h2>{l s='Official Supported Version' mod='binshopsrest'}</h2>
    </a>
    <p class="font-size-100">
        Get the latest supported version and documentation including the amazing features from <a
            href="https://addons.prestashop.com/en/website-performance/52062-rest-api-pro-version-with-fast-api-caching.html"
            target="_blank">Official PrestaShop Addons</a>. Let's take a look at the list of benefits.
    </p>
    <p>
        <b>New!</b> Annotation-based API routing added and structural changes made in version 5.
    </p>
</div>

<div class="panel">
    <h3><i class="icon icon-tags"></i> {l s='Endpoints' mod='binshopsrest'}</h3>
    <p>
        &raquo; {l s='List of endpoints' mod='binshopsrest'} :
    <ul>
        <li>
            Authentication
            <ul>
                <li>Login</li>
                <li>Register</li>
                <li>Logout</li>
            </ul>
        </li>
        <li>
            Cart
            <ul>
                <li>Remove From Cart</li>
                <li>Add Product To Cart</li>
                <li>Cart Items</li>
            </ul>
        </li>
        <li>
            Profile/Account
            <ul>
                <li> User</li>
                <ul>
                    <li>Account Info</li>
                    <li>Account Edit</li>
                </ul>
                <li>Reset Password By ID</li>
                <ul>
                    <li>Set new Password </li>
                </ul>
                <li> Order</li>
                <ul>
                    <li>List of all order for connected customer</li>
                    <li>Order history</li>
                </ul>
            </ul>
        </li>


        <li>
            Reset Password
            <ol>
                <li>Send Reset Password Code</li>
                <li>Check Reset Pass Code</li>
                <li>Reset Password</li>

            </ol>
        </li>
        <li>
            Products
            <ul>
                <li>Product Detail</li>
                <li>Category Products</li>
                <li>Product Search</li>
                <li>Faceted Search</li>
                <li>Featured Products</li>
            </ul>
        </li>
        <li>
            Address
            <ul>
                <li>All Addresses</li>
                <li>Create Address</li>
                <li>Address Form</li>
                <li>Get Address</li>
                <li>Delete Address</li>
            </ul>
        </li>
        <li>
            Checkout
            <ul>
                <li>Set Address</li>
                <li>List All Carriers</li>
                <li>Set Carrier</li>
                <li>Payment Options</li>
                <ul>
                    <li>Bankwire</li>
                    <li>Pay by check</li>
                </ul>
            </ul>
        </li>
        <li>
            Subscription request
            <ol>
                <li>List of internet offers</li>
                <li>Periodicity of the offer</li>
                <li>Test identifier</li>
                <li>List of govs</li>
                <li>List of cities by gov id</li>
                <li>List of post codes by city id</li>
                <li>Otp code</li>
                <li>Add request</li>
            </ol>
        </li>
        <li>
            Paiement factures
            <ul>
                <li>List of non paid invoices</li>
                <li>List of all invoices of a specific customer</li>
                <li>Download invoice</li>

            </ul>
        </li>
    </ul>

    <a href="https://addons.prestashop.com/en/website-performance/52062-rest-api-pro-version-with-fast-api-caching.html"
        target="_blank">More endpoints on Pro version</a>
    </p>
</div>