<script @if(isset($csp_script_nonce) && $csp_script_nonce) nonce="{{ $csp_script_nonce }}" @endif>
    Sfjs = (function() {
        "use strict";

        if ('classList' in document.documentElement) {
            var hasClass = function (el, cssClass) { return el.classList.contains(cssClass); };
            var removeClass = function(el, cssClass) { el.classList.remove(cssClass); };
            var addClass = function(el, cssClass) { el.classList.add(cssClass); };
            var toggleClass = function(el, cssClass) { el.classList.toggle(cssClass); };
        } else {
            var hasClass = function (el, cssClass) { return el.className.match(new RegExp('\\b' + cssClass + '\\b')); };
            var removeClass = function(el, cssClass) { el.className = el.className.replace(new RegExp('\\b' + cssClass + '\\b'), ' '); };
            var addClass = function(el, cssClass) { if (!hasClass(el, cssClass)) { el.className += " " + cssClass; } };
            var toggleClass = function(el, cssClass) { hasClass(el, cssClass) ? removeClass(el, cssClass) : addClass(el, cssClass); };
        }

        var noop = function() {};

        var profilerStorageKey = 'laravel/telescope-toolbar/';

        var addEventListener;

        var el = document.createElement('div');
        if (!('addEventListener' in el)) {
            addEventListener = function (element, eventName, callback) {
                element.attachEvent('on' + eventName, callback);
            };
        } else {
            addEventListener = function (element, eventName, callback) {
                element.addEventListener(eventName, callback, false);
            };
        }

        var request = function(url, onSuccess, onError, payload, options) {
            var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            options = options || {};
            options.maxTries = options.maxTries || 0;
            xhr.open(options.method || 'GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function(state) {
                if (4 !== xhr.readyState) {
                    return null;
                }

                if (xhr.status == 404 && options.maxTries > 1) {
                    setTimeout(function(){
                        options.maxTries--;
                        request(url, onSuccess, onError, payload, options);
                    }, 1000);

                    return null;
                }

                if (200 === xhr.status) {
                    (onSuccess || noop)(xhr);
                } else {
                    (onError || noop)(xhr);
                }
            };
            xhr.send(payload || '');
        };

        var getPreference = function(name) {
            if (!window.localStorage) {
                return null;
            }

            return localStorage.getItem(profilerStorageKey + name);
        };

        var setPreference = function(name, value) {
            if (!window.localStorage) {
                return null;
            }

            localStorage.setItem(profilerStorageKey + name, value);
        };

        var requestStack = [];

        var extractHeaders = function(xhr, stackElement) {
            /* Here we avoid to call xhr.getResponseHeader in order to */
            /* prevent polluting the console with CORS security errors */
            var allHeaders = xhr.getAllResponseHeaders();
            var ret;

            if (ret = allHeaders.match(/^x-debug-token:\s+(.*)$/im)) {
                stackElement.profile = ret[1];
            }
            if (ret = allHeaders.match(/^x-debug-token-link:\s+(.*)$/im)) {
                stackElement.profilerUrl = ret[1];
            }
        };

        var togglePreference = function() {
            var newState = Sfjs.getPreference('toolbar/ajax/replace') !== 'manual' ?  'manual' : 'auto' ;
            Sfjs.setPreference('toolbar/ajax/replace', newState);
            document.querySelector('.sf-toolbar-ajax-replace-state').innerHTML =  newState === 'manual' ? 'Manual' : 'Auto';
        }

        var successStreak = 4;
        var pendingRequests = 0;
        var renderAjaxRequests = function() {
            var requestCounter = document.querySelector('.sf-toolbar-ajax-request-counter');
            if (!requestCounter) {
                return;
            }
            requestCounter.textContent = requestStack.length;

            var infoSpan = document.querySelector(".sf-toolbar-ajax-info");
            if (infoSpan) {
                infoSpan.textContent = requestStack.length + ' Request' + (requestStack.length !== 1 ? 's' : '');
            }

            var ajaxToolbarPanel = document.querySelector('.sf-toolbar-block-ajax');
            if (requestStack.length) {
                ajaxToolbarPanel.style.display = 'block';
            } else {
                ajaxToolbarPanel.style.display = 'none';
            }
            if (pendingRequests > 0) {
                addClass(ajaxToolbarPanel, 'sf-ajax-request-loading');
            } else if (successStreak < 4) {
                addClass(ajaxToolbarPanel, 'sf-toolbar-status-red');
                removeClass(ajaxToolbarPanel, 'sf-ajax-request-loading');
            } else {
                removeClass(ajaxToolbarPanel, 'sf-ajax-request-loading');
                removeClass(ajaxToolbarPanel, 'sf-toolbar-status-red');
            }

            addEventListener(document.querySelector('.sf-toolbar-ajax-clear'), 'click', function() {
                requestStack = [];
                renderAjaxRequests();
                successStreak = 4;
                document.querySelector('.sf-toolbar-ajax-request-list').innerHTML = '';
            });

            document.querySelector('.sf-toolbar-ajax-replace-state').innerHTML = Sfjs.getPreference('toolbar/ajax/replace') === 'manual' ? 'Manual' : 'Auto';
            addEventListener(document.querySelector('.sf-toolbar-ajax-replace-toggle'), 'click', togglePreference);
        };

        var startAjaxRequest = function(index) {
            var tbody = document.querySelector('.sf-toolbar-ajax-request-list');
            if (!tbody) {
                return;
            }

            var nbOfAjaxRequest = tbody.rows.length;
            if (nbOfAjaxRequest >= 100) {
                tbody.deleteRow(0);
            }

            var request = requestStack[index];
            pendingRequests++;
            var row = document.createElement('tr');
            request.DOMNode = row;

            var requestNumberCell = document.createElement('td');
            requestNumberCell.textContent = index + 1;
            row.appendChild(requestNumberCell);

            var profilerCell = document.createElement('td');
            profilerCell.textContent = 'n/a';
            row.appendChild(profilerCell);

            var methodCell = document.createElement('td');
            methodCell.textContent = request.method;
            row.appendChild(methodCell);

            var typeCell = document.createElement('td');
            typeCell.textContent = request.type;
            row.appendChild(typeCell);

            var statusCodeCell = document.createElement('td');
            var statusCode = document.createElement('span');
            statusCode.textContent = 'n/a';
            statusCodeCell.appendChild(statusCode);
            row.appendChild(statusCodeCell);

            var pathCell = document.createElement('td');
            pathCell.className = 'sf-ajax-request-url';
            if ('GET' === request.method) {
                var pathLink = document.createElement('a');
                pathLink.setAttribute('href', request.url);
                pathLink.textContent = request.url;
                pathCell.appendChild(pathLink);
            } else {
                pathCell.textContent = request.url;
            }
            pathCell.setAttribute('title', request.url);
            row.appendChild(pathCell);

            var durationCell = document.createElement('td');
            durationCell.className = 'sf-ajax-request-duration';
            durationCell.textContent = 'n/a';
            row.appendChild(durationCell);

            request.liveDurationHandle = setInterval(function() {
                durationCell.textContent = (new Date() - request.start) + 'ms';
            }, 100);

            row.className = 'sf-ajax-request sf-ajax-request-loading';
            tbody.insertBefore(row, null);

            var toolbarInfo = document.querySelector('.sf-toolbar-block-ajax .sf-toolbar-info');
            if (toolbarInfo) {
              toolbarInfo.scrollTop = toolbarInfo.scrollHeight;
            }

            renderAjaxRequests();
        };

        var finishAjaxRequest = function(index) {
            var request = requestStack[index];
            clearInterval(request.liveDurationHandle);

            if (!request.DOMNode) {
                return;
            }

            if (Sfjs.getPreference('toolbar/ajax/replace') !== 'manual' && !request.toolbarReplaceFinished && request.profile) {
                /* Flag as complete because finishAjaxRequest can be called multiple times. */
                request.toolbarReplaceFinished = true;
                /* Search up through the DOM to find the toolbar's container ID. */
                for (var elem = request.DOMNode; elem && elem !== document; elem = elem.parentNode) {
                    if (elem.id.match(/^sfwdt/)) {
                        Sfjs.loadToolbar(elem.id.replace(/^sfwdt/, ''), request.profile);
                        break;
                    }
                }
            }

            pendingRequests--;
            var row = request.DOMNode;
            /* Unpack the children from the row */
            var profilerCell = row.children[1];
            var methodCell = row.children[2];
            var statusCodeCell = row.children[4];
            var statusCodeElem = statusCodeCell.children[0];
            var durationCell = row.children[6];

            if (request.error) {
                row.className = 'sf-ajax-request sf-ajax-request-error';
                methodCell.className = 'sf-ajax-request-error';
                successStreak = 0;
            } else {
                row.className = 'sf-ajax-request sf-ajax-request-ok';
                successStreak++;
            }

            if (request.statusCode) {
                if (request.statusCode < 300) {
                    statusCodeElem.setAttribute('class', 'sf-toolbar-status');
                } else if (request.statusCode < 400) {
                    statusCodeElem.setAttribute('class', 'sf-toolbar-status sf-toolbar-status-yellow');
                } else {
                    statusCodeElem.setAttribute('class', 'sf-toolbar-status sf-toolbar-status-red');
                }
                statusCodeElem.textContent = request.statusCode;
            } else {
                statusCodeElem.setAttribute('class', 'sf-toolbar-status sf-toolbar-status-red');
            }

            if (request.duration) {
                durationCell.textContent = request.duration + 'ms';
            }

            if (request.profile) {
                profilerCell.textContent = '';
                var profilerLink = document.createElement('a');
                profilerLink.setAttribute('href', request.profilerUrl || '#');
                profilerLink.setAttribute('target', '_profiler');
                profilerLink.textContent = 'Load';

                profilerLink.addEventListener("click", function(e){
                    e.preventDefault();
                    for (var elem = request.DOMNode; elem && elem !== document; elem = elem.parentNode) {
                        if (elem.id.match(/^sfwdt/)) {
                            Sfjs.loadToolbar(elem.id.replace(/^sfwdt/, ''), request.profile);
                            return false;
                        }
                    }
                });

                profilerCell.appendChild(profilerLink);
            }

            renderAjaxRequests();
        };

        @if(isset($excluded_ajax_paths))
        if (window.fetch && window.fetch.polyfill === undefined) {
            var oldFetch = window.fetch;
            window.fetch = function () {
                var promise = oldFetch.apply(this, arguments);
                var url = arguments[0];
                var params = arguments[1];
                var paramType = Object.prototype.toString.call(arguments[0]);
                if (paramType === '[object Request]') {
                    url = arguments[0].url;
                    params = {
                        method: arguments[0].method,
                        credentials: arguments[0].credentials,
                        headers: arguments[0].headers,
                        mode: arguments[0].mode,
                        redirect: arguments[0].redirect
                    };
                } else {
                    url = String(url);
                }
                if (!url.match(new RegExp(@json($excluded_ajax_paths)))) {
                    var method = 'GET';
                    if (params && params.method !== undefined) {
                        method = params.method;
                    }

                    var stackElement = {
                        error: false,
                        url: url,
                        method: method,
                        type: 'fetch',
                        start: new Date()
                    };

                    var idx = requestStack.push(stackElement) - 1;
                    promise.then(function (r) {
                        stackElement.duration = new Date() - stackElement.start;
                        stackElement.error = r.status < 200 || r.status >= 400;
                        stackElement.statusCode = r.status;
                        stackElement.profile = r.headers.get('x-debug-token');
                        stackElement.profilerUrl = r.headers.get('x-debug-token-link');
                        stackElement.toolbarReplaceFinished = false;
                        finishAjaxRequest(idx);
                    }, function (e){
                        stackElement.error = true;
                        finishAjaxRequest(idx);
                    });
                    startAjaxRequest(idx);
                }

                return promise;
            };
        }
        if (window.XMLHttpRequest && XMLHttpRequest.prototype.addEventListener) {
            var proxied = XMLHttpRequest.prototype.open;

            XMLHttpRequest.prototype.open = function(method, url, async, user, pass) {
                var self = this;

                /* prevent logging AJAX calls to static and inline files, like templates */
                var path = url;
                if (url.substr(0, 1) === '/') {
                    if (0 === url.indexOf('{{ asset('/') }}')) {
                        path = url.substr({{ strlen( asset('/')) }});
                    }
                }
                else if (0 === url.indexOf('{{ url('/') }}')) {
                    path = url.substr({{ strlen( url('/')) }});
                }

                if (!path.match(new RegExp(@json($excluded_ajax_paths)))) {
                    var stackElement = {
                        error: false,
                        url: path,
                        method: method,
                        type: 'xhr',
                        start: new Date()
                    };

                    var idx = requestStack.push(stackElement) - 1;

                    this.addEventListener('readystatechange', function() {
                        if (self.readyState == 4) {
                            stackElement.duration = new Date() - stackElement.start;
                            stackElement.error = self.status < 200 || self.status >= 400;
                            stackElement.statusCode = self.status;
                            extractHeaders(self, stackElement);

                            finishAjaxRequest(idx);
                        }
                    }, false);

                    startAjaxRequest(idx);
                }

                proxied.apply(this, Array.prototype.slice.call(arguments));
            };
        }
        @endif

        return {
            hasClass: hasClass,

            removeClass: removeClass,

            addClass: addClass,

            toggleClass: toggleClass,

            getPreference: getPreference,

            setPreference: setPreference,

            addEventListener: addEventListener,

            request: request,

            requestStack: requestStack,

            renderAjaxRequests: renderAjaxRequests,

            load: function(selector, url, onSuccess, onError, options) {
                var el = document.getElementById(selector);

                if (el && el.getAttribute('data-sfurl') !== url) {
                    request(
                        url,
                        function(xhr) {
                            el.innerHTML = xhr.responseText;
                            el.setAttribute('data-sfurl', url);
                            removeClass(el, 'loading');
                            var pending = pendingRequests;
                            for (var i = 0; i < requestStack.length; i++) {
                                startAjaxRequest(i);
                                if (requestStack[i].duration) {
                                    finishAjaxRequest(i);
                                }
                            }
                            /* Revert the pending state in case there was a start called without a finish above. */
                            pendingRequests = pending;
                            (onSuccess || noop)(xhr, el);
                        },
                        function(xhr) { (onError || noop)(xhr, el); },
                        '',
                        options
                    );
                }

                return this;
            },

            loadToolbar: function(token, newToken) {
                newToken = (newToken || token);
                this.load(
                    'sfwdt' + token,
                    '{{ route("telescope-toolbar.render", ["token" => "xxxxxx"]) }}'.replace(/xxxxxx/, newToken),
                    function(xhr, el) {

                        /* Evaluate in global scope scripts embedded inside the toolbar */
                        var i, scripts = [].slice.call(el.querySelectorAll('script'));
                        for (i = 0; i < scripts.length; ++i) {
                            eval.call({}, scripts[i].firstChild.nodeValue);
                        }

                        el.style.display = -1 !== xhr.responseText.indexOf('sf-toolbarreset') ? 'block' : 'none';

                        if (el.style.display == 'none') {
                            return;
                        }

                        if (getPreference('toolbar/displayState') == 'none') {
                            document.getElementById('sfToolbarMainContent-' + newToken).style.display = 'none';
                            document.getElementById('sfToolbarClearer-' + newToken).style.display = 'none';
                            document.getElementById('sfMiniToolbar-' + newToken).style.display = 'block';
                        } else {
                            document.getElementById('sfToolbarMainContent-' + newToken).style.display = 'block';
                            document.getElementById('sfToolbarClearer-' + newToken).style.display = 'block';
                            document.getElementById('sfMiniToolbar-' + newToken).style.display = 'none';
                        }

                        /* Handle toolbar-info position */
                        var toolbarBlocks = [].slice.call(el.querySelectorAll('.sf-toolbar-block'));
                        for (i = 0; i < toolbarBlocks.length; ++i) {
                            toolbarBlocks[i].onmouseover = function () {
                                var toolbarInfo = this.querySelectorAll('.sf-toolbar-info')[0];
                                var pageWidth = document.body.clientWidth;
                                var elementWidth = toolbarInfo.offsetWidth;
                                var leftValue = (elementWidth + this.offsetLeft) - pageWidth;
                                var rightValue = (elementWidth + (pageWidth - this.offsetLeft)) - pageWidth;

                                /* Reset right and left value, useful on window resize */
                                toolbarInfo.style.right = '';
                                toolbarInfo.style.left = '';

                                if (elementWidth > pageWidth) {
                                    toolbarInfo.style.left = 0;
                                }
                                else if (leftValue > 0 && rightValue > 0) {
                                    toolbarInfo.style.right = (rightValue * -1) + 'px';
                                } else if (leftValue < 0) {
                                    toolbarInfo.style.left = 0;
                                } else {
                                    toolbarInfo.style.right = '0px';
                                }
                            };
                        }
                        addEventListener(document.getElementById('sfToolbarHideButton-' + newToken), 'click', function (event) {
                            event.preventDefault();

                            var p = this.parentNode;
                            p.style.display = 'none';
                            (p.previousElementSibling || p.previousSibling).style.display = 'none';
                            document.getElementById('sfMiniToolbar-' + newToken).style.display = 'block';
                            setPreference('toolbar/displayState', 'none');
                        });
                        addEventListener(document.getElementById('sfToolbarMiniToggler-' + newToken), 'click', function (event) {
                            event.preventDefault();

                            var elem = this.parentNode;
                            if (elem.style.display == 'none') {
                                document.getElementById('sfToolbarMainContent-' + newToken).style.display = 'none';
                                document.getElementById('sfToolbarClearer-' + newToken).style.display = 'none';
                                elem.style.display = 'block';
                            } else {
                                document.getElementById('sfToolbarMainContent-' + newToken).style.display = 'block';
                                document.getElementById('sfToolbarClearer-' + newToken).style.display = 'block';
                                elem.style.display = 'none'
                            }

                            setPreference('toolbar/displayState', 'block');
                        });
                        renderAjaxRequests();
                        addEventListener(document.querySelector('.sf-toolbar-block-ajax'), 'mouseenter', function (event) {
                            var elem = document.querySelector('.sf-toolbar-block-ajax .sf-toolbar-info');
                            elem.scrollTop = elem.scrollHeight;
                        });
                        addEventListener(document.querySelector('.sf-toolbar-block-ajax > .sf-toolbar-icon'), 'click', function (event) {
                            event.preventDefault();

                            toggleClass(this.parentNode, 'hover');
                        });

                        var dumpInfo = document.querySelector('.sf-toolbar-block-dump .sf-toolbar-info');
                        if (null !== dumpInfo) {
                            addEventListener(dumpInfo, 'sfbeforedumpcollapse', function () {
                                dumpInfo.style.minHeight = dumpInfo.getBoundingClientRect().height+'px';
                            });
                            addEventListener(dumpInfo, 'mouseleave', function () {
                                dumpInfo.style.minHeight = '';
                            });
                        }
                    },
                    function(xhr) {
                        if (xhr.status !== 0) {
                            var errorMessage = 'An ' + xhr.status + ' error occurred while loading the Telescope Toolbar. Make sure you configured/installed Telescope correctly.';
                            if (xhr.status === 401 || xhr.status === 403) {
                                errorMessage = 'You are unauthorized to view Telescope Requests';
                            }
                            var sfwdt = document.getElementById('sfwdt' + token);
                            var url = '{{ route("telescope") }}';
                            sfwdt.innerHTML = '\
                                <div class="sf-toolbarreset">\
                                    <div class="sf-toolbar-icon"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path fill="#AAA" d="M0 40a39.87 39.87 0 0 1 11.72-28.28A40 40 0 1 1 0 40zm34 10a4 4 0 0 1-4-4v-2a2 2 0 1 0-4 0v2a4 4 0 0 1-4 4h-2a2 2 0 1 0 0 4h2a4 4 0 0 1 4 4v2a2 2 0 1 0 4 0v-2a4 4 0 0 1 4-4h2a2 2 0 1 0 0-4h-2zm24-24a6 6 0 0 1-6-6v-3a3 3 0 0 0-6 0v3a6 6 0 0 1-6 6h-3a3 3 0 0 0 0 6h3a6 6 0 0 1 6 6v3a3 3 0 0 0 6 0v-3a6 6 0 0 1 6-6h3a3 3 0 0 0 0-6h-3zm-4 36a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM21 28a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>\</svg></div>\
                                    ' + errorMessage + ' <a href="' + url + '">Open Telescope.</a>\
                                </div>\
                            ';
                            sfwdt.setAttribute('class', 'sf-toolbar sf-error-toolbar');
                        }
                    },
                    { maxTries: 5 }
                );

                return this;
            },

            toggle: function(selector, elOn, elOff) {
                var tmp = elOn.style.display,
                    el = document.getElementById(selector);

                elOn.style.display = elOff.style.display;
                elOff.style.display = tmp;

                if (el) {
                    el.style.display = 'none' === tmp ? 'none' : 'block';
                }

                return this;
            },

            createTabs: function() {
                var tabGroups = document.querySelectorAll('.sf-tabs:not([data-processed=true])');

                /* create the tab navigation for each group of tabs */
                for (var i = 0; i < tabGroups.length; i++) {
                    var tabs = tabGroups[i].querySelectorAll(':scope > .tab');
                    var tabNavigation = document.createElement('ul');
                    tabNavigation.className = 'tab-navigation';

                    var selectedTabId = 'tab-' + i + '-0'; /* select the first tab by default */
                    for (var j = 0; j < tabs.length; j++) {
                        var tabId = 'tab-' + i + '-' + j;
                        var tabTitle = tabs[j].querySelector('.tab-title').innerHTML;

                        var tabNavigationItem = document.createElement('li');
                        tabNavigationItem.setAttribute('data-tab-id', tabId);
                        if (hasClass(tabs[j], 'active')) { selectedTabId = tabId; }
                        if (hasClass(tabs[j], 'disabled')) { addClass(tabNavigationItem, 'disabled'); }
                        tabNavigationItem.innerHTML = tabTitle;
                        tabNavigation.appendChild(tabNavigationItem);

                        var tabContent = tabs[j].querySelector('.tab-content');
                        tabContent.parentElement.setAttribute('id', tabId);
                    }

                    tabGroups[i].insertBefore(tabNavigation, tabGroups[i].firstChild);
                    addClass(document.querySelector('[data-tab-id="' + selectedTabId + '"]'), 'active');
                }

                /* display the active tab and add the 'click' event listeners */
                for (i = 0; i < tabGroups.length; i++) {
                    tabNavigation = tabGroups[i].querySelectorAll(':scope > .tab-navigation li');

                    for (j = 0; j < tabNavigation.length; j++) {
                        tabId = tabNavigation[j].getAttribute('data-tab-id');
                        document.getElementById(tabId).querySelector('.tab-title').className = 'hidden';

                        if (hasClass(tabNavigation[j], 'active')) {
                            document.getElementById(tabId).className = 'block';
                        } else {
                            document.getElementById(tabId).className = 'hidden';
                        }

                        tabNavigation[j].addEventListener('click', function(e) {
                            var activeTab = e.target || e.srcElement;

                            /* needed because when the tab contains HTML contents, user can click */
                            /* on any of those elements instead of their parent '<li>' element */
                            while (activeTab.tagName.toLowerCase() !== 'li') {
                                activeTab = activeTab.parentNode;
                            }

                            /* get the full list of tabs through the parent of the active tab element */
                            var tabNavigation = activeTab.parentNode.children;
                            for (var k = 0; k < tabNavigation.length; k++) {
                                var tabId = tabNavigation[k].getAttribute('data-tab-id');
                                document.getElementById(tabId).className = 'hidden';
                                removeClass(tabNavigation[k], 'active');
                            }

                            addClass(activeTab, 'active');
                            var activeTabId = activeTab.getAttribute('data-tab-id');
                            document.getElementById(activeTabId).className = 'block';
                        });
                    }

                    tabGroups[i].setAttribute('data-processed', 'true');
                }
            },

            createToggles: function() {
                var toggles = document.querySelectorAll('.sf-toggle:not([data-processed=true])');

                for (var i = 0; i < toggles.length; i++) {
                    var elementSelector = toggles[i].getAttribute('data-toggle-selector');
                    var element = document.querySelector(elementSelector);

                    addClass(element, 'sf-toggle-content');

                    if (toggles[i].hasAttribute('data-toggle-initial') && toggles[i].getAttribute('data-toggle-initial') == 'display') {
                        addClass(toggles[i], 'sf-toggle-on');
                        addClass(element, 'sf-toggle-visible');
                    } else {
                        addClass(toggles[i], 'sf-toggle-off');
                        addClass(element, 'sf-toggle-hidden');
                    }

                    addEventListener(toggles[i], 'click', function(e) {
                        e.preventDefault();

                        if ('' !== window.getSelection().toString()) {
                            /* Don't do anything on text selection */
                            return;
                        }

                        var toggle = e.target || e.srcElement;

                        /* needed because when the toggle contains HTML contents, user can click */
                        /* on any of those elements instead of their parent '.sf-toggle' element */
                        while (!hasClass(toggle, 'sf-toggle')) {
                            toggle = toggle.parentNode;
                        }

                        var element = document.querySelector(toggle.getAttribute('data-toggle-selector'));

                        toggleClass(toggle, 'sf-toggle-on');
                        toggleClass(toggle, 'sf-toggle-off');
                        toggleClass(element, 'sf-toggle-hidden');
                        toggleClass(element, 'sf-toggle-visible');

                        /* the toggle doesn't change its contents when clicking on it */
                        if (!toggle.hasAttribute('data-toggle-alt-content')) {
                            return;
                        }

                        if (!toggle.hasAttribute('data-toggle-original-content')) {
                            toggle.setAttribute('data-toggle-original-content', toggle.innerHTML);
                        }

                        var currentContent = toggle.innerHTML;
                        var originalContent = toggle.getAttribute('data-toggle-original-content');
                        var altContent = toggle.getAttribute('data-toggle-alt-content');
                        toggle.innerHTML = currentContent !== altContent ? altContent : originalContent;
                    });

                    /* Prevents from disallowing clicks on links inside toggles */
                    var toggleLinks = toggles[i].querySelectorAll('a');
                    for (var j = 0; j < toggleLinks.length; j++) {
                        addEventListener(toggleLinks[j], 'click', function(e) {
                            e.stopPropagation();
                        });
                    }

                    toggles[i].setAttribute('data-processed', 'true');
                }
            },

            createFilters: function() {
                document.querySelectorAll('[data-filters] [data-filter]').forEach(function (filter) {
                    var filters = filter.closest('[data-filters]'),
                        type = 'choice',
                        name = filter.dataset.filter,
                        ucName = name.charAt(0).toUpperCase()+name.slice(1),
                        list = document.createElement('ul'),
                        values = filters.dataset['filter'+ucName] || filters.querySelectorAll('[data-filter-'+name+']'),
                        labels = {},
                        defaults = null,
                        indexed = {},
                        processed = {};
                    if (typeof values === 'string') {
                        type = 'level';
                        labels = values.split(',');
                        values = values.toLowerCase().split(',');
                        defaults = values.length - 1;
                    }
                    addClass(list, 'filter-list');
                    addClass(list, 'filter-list-'+type);
                    values.forEach(function (value, i) {
                        if (value instanceof HTMLElement) {
                            value = value.dataset['filter'+ucName];
                        }
                        if (value in processed) {
                            return;
                        }
                        var option = document.createElement('li'),
                            label = i in labels ? labels[i] : value,
                            active = false,
                            matches;
                        if ('' === label) {
                            option.innerHTML = '<em>(none)</em>';
                        } else {
                            option.innerText = label;
                        }
                        option.dataset.filter = value;
                        option.setAttribute('title', 1 === (matches = filters.querySelectorAll('[data-filter-'+name+'="'+value+'"]').length) ? 'Matches 1 row' : 'Matches '+matches+' rows');
                        indexed[value] = i;
                        list.appendChild(option);
                        addEventListener(option, 'click', function () {
                            if ('choice' === type) {
                                filters.querySelectorAll('[data-filter-'+name+']').forEach(function (row) {
                                    if (option.dataset.filter === row.dataset['filter'+ucName]) {
                                        toggleClass(row, 'filter-hidden-'+name);
                                    }
                                });
                                toggleClass(option, 'active');
                            } else if ('level' === type) {
                                if (i === this.parentNode.querySelectorAll('.active').length - 1) {
                                    return;
                                }
                                this.parentNode.querySelectorAll('li').forEach(function (currentOption, j) {
                                    if (j <= i) {
                                        addClass(currentOption, 'active');
                                        if (i === j) {
                                            addClass(currentOption, 'last-active');
                                        } else {
                                            removeClass(currentOption, 'last-active');
                                        }
                                    } else {
                                        removeClass(currentOption, 'active');
                                        removeClass(currentOption, 'last-active');
                                    }
                                });
                                filters.querySelectorAll('[data-filter-'+name+']').forEach(function (row) {
                                    if (i < indexed[row.dataset['filter'+ucName]]) {
                                        addClass(row, 'filter-hidden-'+name);
                                    } else {
                                        removeClass(row, 'filter-hidden-'+name);
                                    }
                                });
                            }
                        });
                        if ('choice' === type) {
                            active = null === defaults || 0 <= defaults.indexOf(value);
                        } else if ('level' === type) {
                            active = i <= defaults;
                            if (active && i === defaults) {
                                addClass(option, 'last-active');
                            }
                        }
                        if (active) {
                            addClass(option, 'active');
                        } else {
                            filters.querySelectorAll('[data-filter-'+name+'="'+value+'"]').forEach(function (row) {
                                toggleClass(row, 'filter-hidden-'+name);
                            });
                        }
                        processed[value] = true;
                    });

                    if (1 < list.childNodes.length) {
                        filter.appendChild(list);
                        filter.dataset.filtered = '';
                    }
                });
            }
        };
    })();

    Sfjs.addEventListener(document, 'DOMContentLoaded', function() {
        Sfjs.createTabs();
        Sfjs.createToggles();
    });
</script>
