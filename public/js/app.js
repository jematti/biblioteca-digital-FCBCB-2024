/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/alpinejs/dist/module.esm.js":
/*!**************************************************!*\
  !*** ./node_modules/alpinejs/dist/module.esm.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ module_default)
/* harmony export */ });
// packages/alpinejs/src/scheduler.js
var flushPending = false;
var flushing = false;
var queue = [];
function scheduler(callback) {
  queueJob(callback);
}
function queueJob(job) {
  if (!queue.includes(job))
    queue.push(job);
  queueFlush();
}
function dequeueJob(job) {
  let index = queue.indexOf(job);
  if (index !== -1)
    queue.splice(index, 1);
}
function queueFlush() {
  if (!flushing && !flushPending) {
    flushPending = true;
    queueMicrotask(flushJobs);
  }
}
function flushJobs() {
  flushPending = false;
  flushing = true;
  for (let i = 0; i < queue.length; i++) {
    queue[i]();
  }
  queue.length = 0;
  flushing = false;
}

// packages/alpinejs/src/reactivity.js
var reactive;
var effect;
var release;
var raw;
var shouldSchedule = true;
function disableEffectScheduling(callback) {
  shouldSchedule = false;
  callback();
  shouldSchedule = true;
}
function setReactivityEngine(engine) {
  reactive = engine.reactive;
  release = engine.release;
  effect = (callback) => engine.effect(callback, {scheduler: (task) => {
    if (shouldSchedule) {
      scheduler(task);
    } else {
      task();
    }
  }});
  raw = engine.raw;
}
function overrideEffect(override) {
  effect = override;
}
function elementBoundEffect(el) {
  let cleanup2 = () => {
  };
  let wrappedEffect = (callback) => {
    let effectReference = effect(callback);
    if (!el._x_effects) {
      el._x_effects = new Set();
      el._x_runEffects = () => {
        el._x_effects.forEach((i) => i());
      };
    }
    el._x_effects.add(effectReference);
    cleanup2 = () => {
      if (effectReference === void 0)
        return;
      el._x_effects.delete(effectReference);
      release(effectReference);
    };
    return effectReference;
  };
  return [wrappedEffect, () => {
    cleanup2();
  }];
}

// packages/alpinejs/src/mutation.js
var onAttributeAddeds = [];
var onElRemoveds = [];
var onElAddeds = [];
function onElAdded(callback) {
  onElAddeds.push(callback);
}
function onElRemoved(el, callback) {
  if (typeof callback === "function") {
    if (!el._x_cleanups)
      el._x_cleanups = [];
    el._x_cleanups.push(callback);
  } else {
    callback = el;
    onElRemoveds.push(callback);
  }
}
function onAttributesAdded(callback) {
  onAttributeAddeds.push(callback);
}
function onAttributeRemoved(el, name, callback) {
  if (!el._x_attributeCleanups)
    el._x_attributeCleanups = {};
  if (!el._x_attributeCleanups[name])
    el._x_attributeCleanups[name] = [];
  el._x_attributeCleanups[name].push(callback);
}
function cleanupAttributes(el, names) {
  if (!el._x_attributeCleanups)
    return;
  Object.entries(el._x_attributeCleanups).forEach(([name, value]) => {
    if (names === void 0 || names.includes(name)) {
      value.forEach((i) => i());
      delete el._x_attributeCleanups[name];
    }
  });
}
var observer = new MutationObserver(onMutate);
var currentlyObserving = false;
function startObservingMutations() {
  observer.observe(document, {subtree: true, childList: true, attributes: true, attributeOldValue: true});
  currentlyObserving = true;
}
function stopObservingMutations() {
  flushObserver();
  observer.disconnect();
  currentlyObserving = false;
}
var recordQueue = [];
var willProcessRecordQueue = false;
function flushObserver() {
  recordQueue = recordQueue.concat(observer.takeRecords());
  if (recordQueue.length && !willProcessRecordQueue) {
    willProcessRecordQueue = true;
    queueMicrotask(() => {
      processRecordQueue();
      willProcessRecordQueue = false;
    });
  }
}
function processRecordQueue() {
  onMutate(recordQueue);
  recordQueue.length = 0;
}
function mutateDom(callback) {
  if (!currentlyObserving)
    return callback();
  stopObservingMutations();
  let result = callback();
  startObservingMutations();
  return result;
}
var isCollecting = false;
var deferredMutations = [];
function deferMutations() {
  isCollecting = true;
}
function flushAndStopDeferringMutations() {
  isCollecting = false;
  onMutate(deferredMutations);
  deferredMutations = [];
}
function onMutate(mutations) {
  if (isCollecting) {
    deferredMutations = deferredMutations.concat(mutations);
    return;
  }
  let addedNodes = [];
  let removedNodes = [];
  let addedAttributes = new Map();
  let removedAttributes = new Map();
  for (let i = 0; i < mutations.length; i++) {
    if (mutations[i].target._x_ignoreMutationObserver)
      continue;
    if (mutations[i].type === "childList") {
      mutations[i].addedNodes.forEach((node) => node.nodeType === 1 && addedNodes.push(node));
      mutations[i].removedNodes.forEach((node) => node.nodeType === 1 && removedNodes.push(node));
    }
    if (mutations[i].type === "attributes") {
      let el = mutations[i].target;
      let name = mutations[i].attributeName;
      let oldValue = mutations[i].oldValue;
      let add2 = () => {
        if (!addedAttributes.has(el))
          addedAttributes.set(el, []);
        addedAttributes.get(el).push({name, value: el.getAttribute(name)});
      };
      let remove = () => {
        if (!removedAttributes.has(el))
          removedAttributes.set(el, []);
        removedAttributes.get(el).push(name);
      };
      if (el.hasAttribute(name) && oldValue === null) {
        add2();
      } else if (el.hasAttribute(name)) {
        remove();
        add2();
      } else {
        remove();
      }
    }
  }
  removedAttributes.forEach((attrs, el) => {
    cleanupAttributes(el, attrs);
  });
  addedAttributes.forEach((attrs, el) => {
    onAttributeAddeds.forEach((i) => i(el, attrs));
  });
  for (let node of removedNodes) {
    if (addedNodes.includes(node))
      continue;
    onElRemoveds.forEach((i) => i(node));
    if (node._x_cleanups) {
      while (node._x_cleanups.length)
        node._x_cleanups.pop()();
    }
  }
  addedNodes.forEach((node) => {
    node._x_ignoreSelf = true;
    node._x_ignore = true;
  });
  for (let node of addedNodes) {
    if (removedNodes.includes(node))
      continue;
    if (!node.isConnected)
      continue;
    delete node._x_ignoreSelf;
    delete node._x_ignore;
    onElAddeds.forEach((i) => i(node));
    node._x_ignore = true;
    node._x_ignoreSelf = true;
  }
  addedNodes.forEach((node) => {
    delete node._x_ignoreSelf;
    delete node._x_ignore;
  });
  addedNodes = null;
  removedNodes = null;
  addedAttributes = null;
  removedAttributes = null;
}

// packages/alpinejs/src/scope.js
function scope(node) {
  return mergeProxies(closestDataStack(node));
}
function addScopeToNode(node, data2, referenceNode) {
  node._x_dataStack = [data2, ...closestDataStack(referenceNode || node)];
  return () => {
    node._x_dataStack = node._x_dataStack.filter((i) => i !== data2);
  };
}
function refreshScope(element, scope2) {
  let existingScope = element._x_dataStack[0];
  Object.entries(scope2).forEach(([key, value]) => {
    existingScope[key] = value;
  });
}
function closestDataStack(node) {
  if (node._x_dataStack)
    return node._x_dataStack;
  if (typeof ShadowRoot === "function" && node instanceof ShadowRoot) {
    return closestDataStack(node.host);
  }
  if (!node.parentNode) {
    return [];
  }
  return closestDataStack(node.parentNode);
}
function mergeProxies(objects) {
  let thisProxy = new Proxy({}, {
    ownKeys: () => {
      return Array.from(new Set(objects.flatMap((i) => Object.keys(i))));
    },
    has: (target, name) => {
      return objects.some((obj) => obj.hasOwnProperty(name));
    },
    get: (target, name) => {
      return (objects.find((obj) => {
        if (obj.hasOwnProperty(name)) {
          let descriptor = Object.getOwnPropertyDescriptor(obj, name);
          if (descriptor.get && descriptor.get._x_alreadyBound || descriptor.set && descriptor.set._x_alreadyBound) {
            return true;
          }
          if ((descriptor.get || descriptor.set) && descriptor.enumerable) {
            let getter = descriptor.get;
            let setter = descriptor.set;
            let property = descriptor;
            getter = getter && getter.bind(thisProxy);
            setter = setter && setter.bind(thisProxy);
            if (getter)
              getter._x_alreadyBound = true;
            if (setter)
              setter._x_alreadyBound = true;
            Object.defineProperty(obj, name, {
              ...property,
              get: getter,
              set: setter
            });
          }
          return true;
        }
        return false;
      }) || {})[name];
    },
    set: (target, name, value) => {
      let closestObjectWithKey = objects.find((obj) => obj.hasOwnProperty(name));
      if (closestObjectWithKey) {
        closestObjectWithKey[name] = value;
      } else {
        objects[objects.length - 1][name] = value;
      }
      return true;
    }
  });
  return thisProxy;
}

// packages/alpinejs/src/interceptor.js
function initInterceptors(data2) {
  let isObject2 = (val) => typeof val === "object" && !Array.isArray(val) && val !== null;
  let recurse = (obj, basePath = "") => {
    Object.entries(Object.getOwnPropertyDescriptors(obj)).forEach(([key, {value, enumerable}]) => {
      if (enumerable === false || value === void 0)
        return;
      let path = basePath === "" ? key : `${basePath}.${key}`;
      if (typeof value === "object" && value !== null && value._x_interceptor) {
        obj[key] = value.initialize(data2, path, key);
      } else {
        if (isObject2(value) && value !== obj && !(value instanceof Element)) {
          recurse(value, path);
        }
      }
    });
  };
  return recurse(data2);
}
function interceptor(callback, mutateObj = () => {
}) {
  let obj = {
    initialValue: void 0,
    _x_interceptor: true,
    initialize(data2, path, key) {
      return callback(this.initialValue, () => get(data2, path), (value) => set(data2, path, value), path, key);
    }
  };
  mutateObj(obj);
  return (initialValue) => {
    if (typeof initialValue === "object" && initialValue !== null && initialValue._x_interceptor) {
      let initialize = obj.initialize.bind(obj);
      obj.initialize = (data2, path, key) => {
        let innerValue = initialValue.initialize(data2, path, key);
        obj.initialValue = innerValue;
        return initialize(data2, path, key);
      };
    } else {
      obj.initialValue = initialValue;
    }
    return obj;
  };
}
function get(obj, path) {
  return path.split(".").reduce((carry, segment) => carry[segment], obj);
}
function set(obj, path, value) {
  if (typeof path === "string")
    path = path.split(".");
  if (path.length === 1)
    obj[path[0]] = value;
  else if (path.length === 0)
    throw error;
  else {
    if (obj[path[0]])
      return set(obj[path[0]], path.slice(1), value);
    else {
      obj[path[0]] = {};
      return set(obj[path[0]], path.slice(1), value);
    }
  }
}

// packages/alpinejs/src/magics.js
var magics = {};
function magic(name, callback) {
  magics[name] = callback;
}
function injectMagics(obj, el) {
  Object.entries(magics).forEach(([name, callback]) => {
    Object.defineProperty(obj, `$${name}`, {
      get() {
        let [utilities, cleanup2] = getElementBoundUtilities(el);
        utilities = {interceptor, ...utilities};
        onElRemoved(el, cleanup2);
        return callback(el, utilities);
      },
      enumerable: false
    });
  });
  return obj;
}

// packages/alpinejs/src/utils/error.js
function tryCatch(el, expression, callback, ...args) {
  try {
    return callback(...args);
  } catch (e) {
    handleError(e, el, expression);
  }
}
function handleError(error2, el, expression = void 0) {
  Object.assign(error2, {el, expression});
  console.warn(`Alpine Expression Error: ${error2.message}

${expression ? 'Expression: "' + expression + '"\n\n' : ""}`, el);
  setTimeout(() => {
    throw error2;
  }, 0);
}

// packages/alpinejs/src/evaluator.js
var shouldAutoEvaluateFunctions = true;
function dontAutoEvaluateFunctions(callback) {
  let cache = shouldAutoEvaluateFunctions;
  shouldAutoEvaluateFunctions = false;
  callback();
  shouldAutoEvaluateFunctions = cache;
}
function evaluate(el, expression, extras = {}) {
  let result;
  evaluateLater(el, expression)((value) => result = value, extras);
  return result;
}
function evaluateLater(...args) {
  return theEvaluatorFunction(...args);
}
var theEvaluatorFunction = normalEvaluator;
function setEvaluator(newEvaluator) {
  theEvaluatorFunction = newEvaluator;
}
function normalEvaluator(el, expression) {
  let overriddenMagics = {};
  injectMagics(overriddenMagics, el);
  let dataStack = [overriddenMagics, ...closestDataStack(el)];
  if (typeof expression === "function") {
    return generateEvaluatorFromFunction(dataStack, expression);
  }
  let evaluator = generateEvaluatorFromString(dataStack, expression, el);
  return tryCatch.bind(null, el, expression, evaluator);
}
function generateEvaluatorFromFunction(dataStack, func) {
  return (receiver = () => {
  }, {scope: scope2 = {}, params = []} = {}) => {
    let result = func.apply(mergeProxies([scope2, ...dataStack]), params);
    runIfTypeOfFunction(receiver, result);
  };
}
var evaluatorMemo = {};
function generateFunctionFromString(expression, el) {
  if (evaluatorMemo[expression]) {
    return evaluatorMemo[expression];
  }
  let AsyncFunction = Object.getPrototypeOf(async function() {
  }).constructor;
  let rightSideSafeExpression = /^[\n\s]*if.*\(.*\)/.test(expression) || /^(let|const)\s/.test(expression) ? `(() => { ${expression} })()` : expression;
  const safeAsyncFunction = () => {
    try {
      return new AsyncFunction(["__self", "scope"], `with (scope) { __self.result = ${rightSideSafeExpression} }; __self.finished = true; return __self.result;`);
    } catch (error2) {
      handleError(error2, el, expression);
      return Promise.resolve();
    }
  };
  let func = safeAsyncFunction();
  evaluatorMemo[expression] = func;
  return func;
}
function generateEvaluatorFromString(dataStack, expression, el) {
  let func = generateFunctionFromString(expression, el);
  return (receiver = () => {
  }, {scope: scope2 = {}, params = []} = {}) => {
    func.result = void 0;
    func.finished = false;
    let completeScope = mergeProxies([scope2, ...dataStack]);
    if (typeof func === "function") {
      let promise = func(func, completeScope).catch((error2) => handleError(error2, el, expression));
      if (func.finished) {
        runIfTypeOfFunction(receiver, func.result, completeScope, params, el);
        func.result = void 0;
      } else {
        promise.then((result) => {
          runIfTypeOfFunction(receiver, result, completeScope, params, el);
        }).catch((error2) => handleError(error2, el, expression)).finally(() => func.result = void 0);
      }
    }
  };
}
function runIfTypeOfFunction(receiver, value, scope2, params, el) {
  if (shouldAutoEvaluateFunctions && typeof value === "function") {
    let result = value.apply(scope2, params);
    if (result instanceof Promise) {
      result.then((i) => runIfTypeOfFunction(receiver, i, scope2, params)).catch((error2) => handleError(error2, el, value));
    } else {
      receiver(result);
    }
  } else {
    receiver(value);
  }
}

// packages/alpinejs/src/directives.js
var prefixAsString = "x-";
function prefix(subject = "") {
  return prefixAsString + subject;
}
function setPrefix(newPrefix) {
  prefixAsString = newPrefix;
}
var directiveHandlers = {};
function directive(name, callback) {
  directiveHandlers[name] = callback;
}
function directives(el, attributes, originalAttributeOverride) {
  attributes = Array.from(attributes);
  if (el._x_virtualDirectives) {
    let vAttributes = Object.entries(el._x_virtualDirectives).map(([name, value]) => ({name, value}));
    let staticAttributes = attributesOnly(vAttributes);
    vAttributes = vAttributes.map((attribute) => {
      if (staticAttributes.find((attr) => attr.name === attribute.name)) {
        return {
          name: `x-bind:${attribute.name}`,
          value: `"${attribute.value}"`
        };
      }
      return attribute;
    });
    attributes = attributes.concat(vAttributes);
  }
  let transformedAttributeMap = {};
  let directives2 = attributes.map(toTransformedAttributes((newName, oldName) => transformedAttributeMap[newName] = oldName)).filter(outNonAlpineAttributes).map(toParsedDirectives(transformedAttributeMap, originalAttributeOverride)).sort(byPriority);
  return directives2.map((directive2) => {
    return getDirectiveHandler(el, directive2);
  });
}
function attributesOnly(attributes) {
  return Array.from(attributes).map(toTransformedAttributes()).filter((attr) => !outNonAlpineAttributes(attr));
}
var isDeferringHandlers = false;
var directiveHandlerStacks = new Map();
var currentHandlerStackKey = Symbol();
function deferHandlingDirectives(callback) {
  isDeferringHandlers = true;
  let key = Symbol();
  currentHandlerStackKey = key;
  directiveHandlerStacks.set(key, []);
  let flushHandlers = () => {
    while (directiveHandlerStacks.get(key).length)
      directiveHandlerStacks.get(key).shift()();
    directiveHandlerStacks.delete(key);
  };
  let stopDeferring = () => {
    isDeferringHandlers = false;
    flushHandlers();
  };
  callback(flushHandlers);
  stopDeferring();
}
function getElementBoundUtilities(el) {
  let cleanups = [];
  let cleanup2 = (callback) => cleanups.push(callback);
  let [effect3, cleanupEffect] = elementBoundEffect(el);
  cleanups.push(cleanupEffect);
  let utilities = {
    Alpine: alpine_default,
    effect: effect3,
    cleanup: cleanup2,
    evaluateLater: evaluateLater.bind(evaluateLater, el),
    evaluate: evaluate.bind(evaluate, el)
  };
  let doCleanup = () => cleanups.forEach((i) => i());
  return [utilities, doCleanup];
}
function getDirectiveHandler(el, directive2) {
  let noop = () => {
  };
  let handler3 = directiveHandlers[directive2.type] || noop;
  let [utilities, cleanup2] = getElementBoundUtilities(el);
  onAttributeRemoved(el, directive2.original, cleanup2);
  let fullHandler = () => {
    if (el._x_ignore || el._x_ignoreSelf)
      return;
    handler3.inline && handler3.inline(el, directive2, utilities);
    handler3 = handler3.bind(handler3, el, directive2, utilities);
    isDeferringHandlers ? directiveHandlerStacks.get(currentHandlerStackKey).push(handler3) : handler3();
  };
  fullHandler.runCleanups = cleanup2;
  return fullHandler;
}
var startingWith = (subject, replacement) => ({name, value}) => {
  if (name.startsWith(subject))
    name = name.replace(subject, replacement);
  return {name, value};
};
var into = (i) => i;
function toTransformedAttributes(callback = () => {
}) {
  return ({name, value}) => {
    let {name: newName, value: newValue} = attributeTransformers.reduce((carry, transform) => {
      return transform(carry);
    }, {name, value});
    if (newName !== name)
      callback(newName, name);
    return {name: newName, value: newValue};
  };
}
var attributeTransformers = [];
function mapAttributes(callback) {
  attributeTransformers.push(callback);
}
function outNonAlpineAttributes({name}) {
  return alpineAttributeRegex().test(name);
}
var alpineAttributeRegex = () => new RegExp(`^${prefixAsString}([^:^.]+)\\b`);
function toParsedDirectives(transformedAttributeMap, originalAttributeOverride) {
  return ({name, value}) => {
    let typeMatch = name.match(alpineAttributeRegex());
    let valueMatch = name.match(/:([a-zA-Z0-9\-:]+)/);
    let modifiers = name.match(/\.[^.\]]+(?=[^\]]*$)/g) || [];
    let original = originalAttributeOverride || transformedAttributeMap[name] || name;
    return {
      type: typeMatch ? typeMatch[1] : null,
      value: valueMatch ? valueMatch[1] : null,
      modifiers: modifiers.map((i) => i.replace(".", "")),
      expression: value,
      original
    };
  };
}
var DEFAULT = "DEFAULT";
var directiveOrder = [
  "ignore",
  "ref",
  "data",
  "id",
  "radio",
  "tabs",
  "switch",
  "disclosure",
  "menu",
  "listbox",
  "list",
  "item",
  "combobox",
  "bind",
  "init",
  "for",
  "mask",
  "model",
  "modelable",
  "transition",
  "show",
  "if",
  DEFAULT,
  "teleport"
];
function byPriority(a, b) {
  let typeA = directiveOrder.indexOf(a.type) === -1 ? DEFAULT : a.type;
  let typeB = directiveOrder.indexOf(b.type) === -1 ? DEFAULT : b.type;
  return directiveOrder.indexOf(typeA) - directiveOrder.indexOf(typeB);
}

// packages/alpinejs/src/utils/dispatch.js
function dispatch(el, name, detail = {}) {
  el.dispatchEvent(new CustomEvent(name, {
    detail,
    bubbles: true,
    composed: true,
    cancelable: true
  }));
}

// packages/alpinejs/src/nextTick.js
var tickStack = [];
var isHolding = false;
function nextTick(callback = () => {
}) {
  queueMicrotask(() => {
    isHolding || setTimeout(() => {
      releaseNextTicks();
    });
  });
  return new Promise((res) => {
    tickStack.push(() => {
      callback();
      res();
    });
  });
}
function releaseNextTicks() {
  isHolding = false;
  while (tickStack.length)
    tickStack.shift()();
}
function holdNextTicks() {
  isHolding = true;
}

// packages/alpinejs/src/utils/walk.js
function walk(el, callback) {
  if (typeof ShadowRoot === "function" && el instanceof ShadowRoot) {
    Array.from(el.children).forEach((el2) => walk(el2, callback));
    return;
  }
  let skip = false;
  callback(el, () => skip = true);
  if (skip)
    return;
  let node = el.firstElementChild;
  while (node) {
    walk(node, callback, false);
    node = node.nextElementSibling;
  }
}

// packages/alpinejs/src/utils/warn.js
function warn(message, ...args) {
  console.warn(`Alpine Warning: ${message}`, ...args);
}

// packages/alpinejs/src/lifecycle.js
function start() {
  if (!document.body)
    warn("Unable to initialize. Trying to load Alpine before `<body>` is available. Did you forget to add `defer` in Alpine's `<script>` tag?");
  dispatch(document, "alpine:init");
  dispatch(document, "alpine:initializing");
  startObservingMutations();
  onElAdded((el) => initTree(el, walk));
  onElRemoved((el) => destroyTree(el));
  onAttributesAdded((el, attrs) => {
    directives(el, attrs).forEach((handle) => handle());
  });
  let outNestedComponents = (el) => !closestRoot(el.parentElement, true);
  Array.from(document.querySelectorAll(allSelectors())).filter(outNestedComponents).forEach((el) => {
    initTree(el);
  });
  dispatch(document, "alpine:initialized");
}
var rootSelectorCallbacks = [];
var initSelectorCallbacks = [];
function rootSelectors() {
  return rootSelectorCallbacks.map((fn) => fn());
}
function allSelectors() {
  return rootSelectorCallbacks.concat(initSelectorCallbacks).map((fn) => fn());
}
function addRootSelector(selectorCallback) {
  rootSelectorCallbacks.push(selectorCallback);
}
function addInitSelector(selectorCallback) {
  initSelectorCallbacks.push(selectorCallback);
}
function closestRoot(el, includeInitSelectors = false) {
  return findClosest(el, (element) => {
    const selectors = includeInitSelectors ? allSelectors() : rootSelectors();
    if (selectors.some((selector) => element.matches(selector)))
      return true;
  });
}
function findClosest(el, callback) {
  if (!el)
    return;
  if (callback(el))
    return el;
  if (el._x_teleportBack)
    el = el._x_teleportBack;
  if (!el.parentElement)
    return;
  return findClosest(el.parentElement, callback);
}
function isRoot(el) {
  return rootSelectors().some((selector) => el.matches(selector));
}
function initTree(el, walker = walk) {
  deferHandlingDirectives(() => {
    walker(el, (el2, skip) => {
      directives(el2, el2.attributes).forEach((handle) => handle());
      el2._x_ignore && skip();
    });
  });
}
function destroyTree(root) {
  walk(root, (el) => cleanupAttributes(el));
}

// packages/alpinejs/src/utils/classes.js
function setClasses(el, value) {
  if (Array.isArray(value)) {
    return setClassesFromString(el, value.join(" "));
  } else if (typeof value === "object" && value !== null) {
    return setClassesFromObject(el, value);
  } else if (typeof value === "function") {
    return setClasses(el, value());
  }
  return setClassesFromString(el, value);
}
function setClassesFromString(el, classString) {
  let split = (classString2) => classString2.split(" ").filter(Boolean);
  let missingClasses = (classString2) => classString2.split(" ").filter((i) => !el.classList.contains(i)).filter(Boolean);
  let addClassesAndReturnUndo = (classes) => {
    el.classList.add(...classes);
    return () => {
      el.classList.remove(...classes);
    };
  };
  classString = classString === true ? classString = "" : classString || "";
  return addClassesAndReturnUndo(missingClasses(classString));
}
function setClassesFromObject(el, classObject) {
  let split = (classString) => classString.split(" ").filter(Boolean);
  let forAdd = Object.entries(classObject).flatMap(([classString, bool]) => bool ? split(classString) : false).filter(Boolean);
  let forRemove = Object.entries(classObject).flatMap(([classString, bool]) => !bool ? split(classString) : false).filter(Boolean);
  let added = [];
  let removed = [];
  forRemove.forEach((i) => {
    if (el.classList.contains(i)) {
      el.classList.remove(i);
      removed.push(i);
    }
  });
  forAdd.forEach((i) => {
    if (!el.classList.contains(i)) {
      el.classList.add(i);
      added.push(i);
    }
  });
  return () => {
    removed.forEach((i) => el.classList.add(i));
    added.forEach((i) => el.classList.remove(i));
  };
}

// packages/alpinejs/src/utils/styles.js
function setStyles(el, value) {
  if (typeof value === "object" && value !== null) {
    return setStylesFromObject(el, value);
  }
  return setStylesFromString(el, value);
}
function setStylesFromObject(el, value) {
  let previousStyles = {};
  Object.entries(value).forEach(([key, value2]) => {
    previousStyles[key] = el.style[key];
    if (!key.startsWith("--")) {
      key = kebabCase(key);
    }
    el.style.setProperty(key, value2);
  });
  setTimeout(() => {
    if (el.style.length === 0) {
      el.removeAttribute("style");
    }
  });
  return () => {
    setStyles(el, previousStyles);
  };
}
function setStylesFromString(el, value) {
  let cache = el.getAttribute("style", value);
  el.setAttribute("style", value);
  return () => {
    el.setAttribute("style", cache || "");
  };
}
function kebabCase(subject) {
  return subject.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase();
}

// packages/alpinejs/src/utils/once.js
function once(callback, fallback = () => {
}) {
  let called = false;
  return function() {
    if (!called) {
      called = true;
      callback.apply(this, arguments);
    } else {
      fallback.apply(this, arguments);
    }
  };
}

// packages/alpinejs/src/directives/x-transition.js
directive("transition", (el, {value, modifiers, expression}, {evaluate: evaluate2}) => {
  if (typeof expression === "function")
    expression = evaluate2(expression);
  if (!expression) {
    registerTransitionsFromHelper(el, modifiers, value);
  } else {
    registerTransitionsFromClassString(el, expression, value);
  }
});
function registerTransitionsFromClassString(el, classString, stage) {
  registerTransitionObject(el, setClasses, "");
  let directiveStorageMap = {
    enter: (classes) => {
      el._x_transition.enter.during = classes;
    },
    "enter-start": (classes) => {
      el._x_transition.enter.start = classes;
    },
    "enter-end": (classes) => {
      el._x_transition.enter.end = classes;
    },
    leave: (classes) => {
      el._x_transition.leave.during = classes;
    },
    "leave-start": (classes) => {
      el._x_transition.leave.start = classes;
    },
    "leave-end": (classes) => {
      el._x_transition.leave.end = classes;
    }
  };
  directiveStorageMap[stage](classString);
}
function registerTransitionsFromHelper(el, modifiers, stage) {
  registerTransitionObject(el, setStyles);
  let doesntSpecify = !modifiers.includes("in") && !modifiers.includes("out") && !stage;
  let transitioningIn = doesntSpecify || modifiers.includes("in") || ["enter"].includes(stage);
  let transitioningOut = doesntSpecify || modifiers.includes("out") || ["leave"].includes(stage);
  if (modifiers.includes("in") && !doesntSpecify) {
    modifiers = modifiers.filter((i, index) => index < modifiers.indexOf("out"));
  }
  if (modifiers.includes("out") && !doesntSpecify) {
    modifiers = modifiers.filter((i, index) => index > modifiers.indexOf("out"));
  }
  let wantsAll = !modifiers.includes("opacity") && !modifiers.includes("scale");
  let wantsOpacity = wantsAll || modifiers.includes("opacity");
  let wantsScale = wantsAll || modifiers.includes("scale");
  let opacityValue = wantsOpacity ? 0 : 1;
  let scaleValue = wantsScale ? modifierValue(modifiers, "scale", 95) / 100 : 1;
  let delay = modifierValue(modifiers, "delay", 0);
  let origin = modifierValue(modifiers, "origin", "center");
  let property = "opacity, transform";
  let durationIn = modifierValue(modifiers, "duration", 150) / 1e3;
  let durationOut = modifierValue(modifiers, "duration", 75) / 1e3;
  let easing = `cubic-bezier(0.4, 0.0, 0.2, 1)`;
  if (transitioningIn) {
    el._x_transition.enter.during = {
      transformOrigin: origin,
      transitionDelay: delay,
      transitionProperty: property,
      transitionDuration: `${durationIn}s`,
      transitionTimingFunction: easing
    };
    el._x_transition.enter.start = {
      opacity: opacityValue,
      transform: `scale(${scaleValue})`
    };
    el._x_transition.enter.end = {
      opacity: 1,
      transform: `scale(1)`
    };
  }
  if (transitioningOut) {
    el._x_transition.leave.during = {
      transformOrigin: origin,
      transitionDelay: delay,
      transitionProperty: property,
      transitionDuration: `${durationOut}s`,
      transitionTimingFunction: easing
    };
    el._x_transition.leave.start = {
      opacity: 1,
      transform: `scale(1)`
    };
    el._x_transition.leave.end = {
      opacity: opacityValue,
      transform: `scale(${scaleValue})`
    };
  }
}
function registerTransitionObject(el, setFunction, defaultValue = {}) {
  if (!el._x_transition)
    el._x_transition = {
      enter: {during: defaultValue, start: defaultValue, end: defaultValue},
      leave: {during: defaultValue, start: defaultValue, end: defaultValue},
      in(before = () => {
      }, after = () => {
      }) {
        transition(el, setFunction, {
          during: this.enter.during,
          start: this.enter.start,
          end: this.enter.end
        }, before, after);
      },
      out(before = () => {
      }, after = () => {
      }) {
        transition(el, setFunction, {
          during: this.leave.during,
          start: this.leave.start,
          end: this.leave.end
        }, before, after);
      }
    };
}
window.Element.prototype._x_toggleAndCascadeWithTransitions = function(el, value, show, hide) {
  const nextTick2 = document.visibilityState === "visible" ? requestAnimationFrame : setTimeout;
  let clickAwayCompatibleShow = () => nextTick2(show);
  if (value) {
    if (el._x_transition && (el._x_transition.enter || el._x_transition.leave)) {
      el._x_transition.enter && (Object.entries(el._x_transition.enter.during).length || Object.entries(el._x_transition.enter.start).length || Object.entries(el._x_transition.enter.end).length) ? el._x_transition.in(show) : clickAwayCompatibleShow();
    } else {
      el._x_transition ? el._x_transition.in(show) : clickAwayCompatibleShow();
    }
    return;
  }
  el._x_hidePromise = el._x_transition ? new Promise((resolve, reject) => {
    el._x_transition.out(() => {
    }, () => resolve(hide));
    el._x_transitioning.beforeCancel(() => reject({isFromCancelledTransition: true}));
  }) : Promise.resolve(hide);
  queueMicrotask(() => {
    let closest = closestHide(el);
    if (closest) {
      if (!closest._x_hideChildren)
        closest._x_hideChildren = [];
      closest._x_hideChildren.push(el);
    } else {
      nextTick2(() => {
        let hideAfterChildren = (el2) => {
          let carry = Promise.all([
            el2._x_hidePromise,
            ...(el2._x_hideChildren || []).map(hideAfterChildren)
          ]).then(([i]) => i());
          delete el2._x_hidePromise;
          delete el2._x_hideChildren;
          return carry;
        };
        hideAfterChildren(el).catch((e) => {
          if (!e.isFromCancelledTransition)
            throw e;
        });
      });
    }
  });
};
function closestHide(el) {
  let parent = el.parentNode;
  if (!parent)
    return;
  return parent._x_hidePromise ? parent : closestHide(parent);
}
function transition(el, setFunction, {during, start: start2, end} = {}, before = () => {
}, after = () => {
}) {
  if (el._x_transitioning)
    el._x_transitioning.cancel();
  if (Object.keys(during).length === 0 && Object.keys(start2).length === 0 && Object.keys(end).length === 0) {
    before();
    after();
    return;
  }
  let undoStart, undoDuring, undoEnd;
  performTransition(el, {
    start() {
      undoStart = setFunction(el, start2);
    },
    during() {
      undoDuring = setFunction(el, during);
    },
    before,
    end() {
      undoStart();
      undoEnd = setFunction(el, end);
    },
    after,
    cleanup() {
      undoDuring();
      undoEnd();
    }
  });
}
function performTransition(el, stages) {
  let interrupted, reachedBefore, reachedEnd;
  let finish = once(() => {
    mutateDom(() => {
      interrupted = true;
      if (!reachedBefore)
        stages.before();
      if (!reachedEnd) {
        stages.end();
        releaseNextTicks();
      }
      stages.after();
      if (el.isConnected)
        stages.cleanup();
      delete el._x_transitioning;
    });
  });
  el._x_transitioning = {
    beforeCancels: [],
    beforeCancel(callback) {
      this.beforeCancels.push(callback);
    },
    cancel: once(function() {
      while (this.beforeCancels.length) {
        this.beforeCancels.shift()();
      }
      ;
      finish();
    }),
    finish
  };
  mutateDom(() => {
    stages.start();
    stages.during();
  });
  holdNextTicks();
  requestAnimationFrame(() => {
    if (interrupted)
      return;
    let duration = Number(getComputedStyle(el).transitionDuration.replace(/,.*/, "").replace("s", "")) * 1e3;
    let delay = Number(getComputedStyle(el).transitionDelay.replace(/,.*/, "").replace("s", "")) * 1e3;
    if (duration === 0)
      duration = Number(getComputedStyle(el).animationDuration.replace("s", "")) * 1e3;
    mutateDom(() => {
      stages.before();
    });
    reachedBefore = true;
    requestAnimationFrame(() => {
      if (interrupted)
        return;
      mutateDom(() => {
        stages.end();
      });
      releaseNextTicks();
      setTimeout(el._x_transitioning.finish, duration + delay);
      reachedEnd = true;
    });
  });
}
function modifierValue(modifiers, key, fallback) {
  if (modifiers.indexOf(key) === -1)
    return fallback;
  const rawValue = modifiers[modifiers.indexOf(key) + 1];
  if (!rawValue)
    return fallback;
  if (key === "scale") {
    if (isNaN(rawValue))
      return fallback;
  }
  if (key === "duration") {
    let match = rawValue.match(/([0-9]+)ms/);
    if (match)
      return match[1];
  }
  if (key === "origin") {
    if (["top", "right", "left", "center", "bottom"].includes(modifiers[modifiers.indexOf(key) + 2])) {
      return [rawValue, modifiers[modifiers.indexOf(key) + 2]].join(" ");
    }
  }
  return rawValue;
}

// packages/alpinejs/src/clone.js
var isCloning = false;
function skipDuringClone(callback, fallback = () => {
}) {
  return (...args) => isCloning ? fallback(...args) : callback(...args);
}
function clone(oldEl, newEl) {
  if (!newEl._x_dataStack)
    newEl._x_dataStack = oldEl._x_dataStack;
  isCloning = true;
  dontRegisterReactiveSideEffects(() => {
    cloneTree(newEl);
  });
  isCloning = false;
}
function cloneTree(el) {
  let hasRunThroughFirstEl = false;
  let shallowWalker = (el2, callback) => {
    walk(el2, (el3, skip) => {
      if (hasRunThroughFirstEl && isRoot(el3))
        return skip();
      hasRunThroughFirstEl = true;
      callback(el3, skip);
    });
  };
  initTree(el, shallowWalker);
}
function dontRegisterReactiveSideEffects(callback) {
  let cache = effect;
  overrideEffect((callback2, el) => {
    let storedEffect = cache(callback2);
    release(storedEffect);
    return () => {
    };
  });
  callback();
  overrideEffect(cache);
}

// packages/alpinejs/src/utils/bind.js
function bind(el, name, value, modifiers = []) {
  if (!el._x_bindings)
    el._x_bindings = reactive({});
  el._x_bindings[name] = value;
  name = modifiers.includes("camel") ? camelCase(name) : name;
  switch (name) {
    case "value":
      bindInputValue(el, value);
      break;
    case "style":
      bindStyles(el, value);
      break;
    case "class":
      bindClasses(el, value);
      break;
    default:
      bindAttribute(el, name, value);
      break;
  }
}
function bindInputValue(el, value) {
  if (el.type === "radio") {
    if (el.attributes.value === void 0) {
      el.value = value;
    }
    if (window.fromModel) {
      el.checked = checkedAttrLooseCompare(el.value, value);
    }
  } else if (el.type === "checkbox") {
    if (Number.isInteger(value)) {
      el.value = value;
    } else if (!Number.isInteger(value) && !Array.isArray(value) && typeof value !== "boolean" && ![null, void 0].includes(value)) {
      el.value = String(value);
    } else {
      if (Array.isArray(value)) {
        el.checked = value.some((val) => checkedAttrLooseCompare(val, el.value));
      } else {
        el.checked = !!value;
      }
    }
  } else if (el.tagName === "SELECT") {
    updateSelect(el, value);
  } else {
    if (el.value === value)
      return;
    el.value = value;
  }
}
function bindClasses(el, value) {
  if (el._x_undoAddedClasses)
    el._x_undoAddedClasses();
  el._x_undoAddedClasses = setClasses(el, value);
}
function bindStyles(el, value) {
  if (el._x_undoAddedStyles)
    el._x_undoAddedStyles();
  el._x_undoAddedStyles = setStyles(el, value);
}
function bindAttribute(el, name, value) {
  if ([null, void 0, false].includes(value) && attributeShouldntBePreservedIfFalsy(name)) {
    el.removeAttribute(name);
  } else {
    if (isBooleanAttr(name))
      value = name;
    setIfChanged(el, name, value);
  }
}
function setIfChanged(el, attrName, value) {
  if (el.getAttribute(attrName) != value) {
    el.setAttribute(attrName, value);
  }
}
function updateSelect(el, value) {
  const arrayWrappedValue = [].concat(value).map((value2) => {
    return value2 + "";
  });
  Array.from(el.options).forEach((option) => {
    option.selected = arrayWrappedValue.includes(option.value);
  });
}
function camelCase(subject) {
  return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
}
function checkedAttrLooseCompare(valueA, valueB) {
  return valueA == valueB;
}
function isBooleanAttr(attrName) {
  const booleanAttributes = [
    "disabled",
    "checked",
    "required",
    "readonly",
    "hidden",
    "open",
    "selected",
    "autofocus",
    "itemscope",
    "multiple",
    "novalidate",
    "allowfullscreen",
    "allowpaymentrequest",
    "formnovalidate",
    "autoplay",
    "controls",
    "loop",
    "muted",
    "playsinline",
    "default",
    "ismap",
    "reversed",
    "async",
    "defer",
    "nomodule"
  ];
  return booleanAttributes.includes(attrName);
}
function attributeShouldntBePreservedIfFalsy(name) {
  return !["aria-pressed", "aria-checked", "aria-expanded", "aria-selected"].includes(name);
}
function getBinding(el, name, fallback) {
  if (el._x_bindings && el._x_bindings[name] !== void 0)
    return el._x_bindings[name];
  let attr = el.getAttribute(name);
  if (attr === null)
    return typeof fallback === "function" ? fallback() : fallback;
  if (attr === "")
    return true;
  if (isBooleanAttr(name)) {
    return !![name, "true"].includes(attr);
  }
  return attr;
}

// packages/alpinejs/src/utils/debounce.js
function debounce(func, wait) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      func.apply(context, args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// packages/alpinejs/src/utils/throttle.js
function throttle(func, limit) {
  let inThrottle;
  return function() {
    let context = this, args = arguments;
    if (!inThrottle) {
      func.apply(context, args);
      inThrottle = true;
      setTimeout(() => inThrottle = false, limit);
    }
  };
}

// packages/alpinejs/src/plugin.js
function plugin(callback) {
  callback(alpine_default);
}

// packages/alpinejs/src/store.js
var stores = {};
var isReactive = false;
function store(name, value) {
  if (!isReactive) {
    stores = reactive(stores);
    isReactive = true;
  }
  if (value === void 0) {
    return stores[name];
  }
  stores[name] = value;
  if (typeof value === "object" && value !== null && value.hasOwnProperty("init") && typeof value.init === "function") {
    stores[name].init();
  }
  initInterceptors(stores[name]);
}
function getStores() {
  return stores;
}

// packages/alpinejs/src/binds.js
var binds = {};
function bind2(name, bindings) {
  let getBindings = typeof bindings !== "function" ? () => bindings : bindings;
  if (name instanceof Element) {
    applyBindingsObject(name, getBindings());
  } else {
    binds[name] = getBindings;
  }
}
function injectBindingProviders(obj) {
  Object.entries(binds).forEach(([name, callback]) => {
    Object.defineProperty(obj, name, {
      get() {
        return (...args) => {
          return callback(...args);
        };
      }
    });
  });
  return obj;
}
function applyBindingsObject(el, obj, original) {
  let cleanupRunners = [];
  while (cleanupRunners.length)
    cleanupRunners.pop()();
  let attributes = Object.entries(obj).map(([name, value]) => ({name, value}));
  let staticAttributes = attributesOnly(attributes);
  attributes = attributes.map((attribute) => {
    if (staticAttributes.find((attr) => attr.name === attribute.name)) {
      return {
        name: `x-bind:${attribute.name}`,
        value: `"${attribute.value}"`
      };
    }
    return attribute;
  });
  directives(el, attributes, original).map((handle) => {
    cleanupRunners.push(handle.runCleanups);
    handle();
  });
}

// packages/alpinejs/src/datas.js
var datas = {};
function data(name, callback) {
  datas[name] = callback;
}
function injectDataProviders(obj, context) {
  Object.entries(datas).forEach(([name, callback]) => {
    Object.defineProperty(obj, name, {
      get() {
        return (...args) => {
          return callback.bind(context)(...args);
        };
      },
      enumerable: false
    });
  });
  return obj;
}

// packages/alpinejs/src/alpine.js
var Alpine = {
  get reactive() {
    return reactive;
  },
  get release() {
    return release;
  },
  get effect() {
    return effect;
  },
  get raw() {
    return raw;
  },
  version: "3.10.5",
  flushAndStopDeferringMutations,
  dontAutoEvaluateFunctions,
  disableEffectScheduling,
  setReactivityEngine,
  closestDataStack,
  skipDuringClone,
  addRootSelector,
  addInitSelector,
  addScopeToNode,
  deferMutations,
  mapAttributes,
  evaluateLater,
  setEvaluator,
  mergeProxies,
  findClosest,
  closestRoot,
  interceptor,
  transition,
  setStyles,
  mutateDom,
  directive,
  throttle,
  debounce,
  evaluate,
  initTree,
  nextTick,
  prefixed: prefix,
  prefix: setPrefix,
  plugin,
  magic,
  store,
  start,
  clone,
  bound: getBinding,
  $data: scope,
  data,
  bind: bind2
};
var alpine_default = Alpine;

// node_modules/@vue/shared/dist/shared.esm-bundler.js
function makeMap(str, expectsLowerCase) {
  const map = Object.create(null);
  const list = str.split(",");
  for (let i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase ? (val) => !!map[val.toLowerCase()] : (val) => !!map[val];
}
var PatchFlagNames = {
  [1]: `TEXT`,
  [2]: `CLASS`,
  [4]: `STYLE`,
  [8]: `PROPS`,
  [16]: `FULL_PROPS`,
  [32]: `HYDRATE_EVENTS`,
  [64]: `STABLE_FRAGMENT`,
  [128]: `KEYED_FRAGMENT`,
  [256]: `UNKEYED_FRAGMENT`,
  [512]: `NEED_PATCH`,
  [1024]: `DYNAMIC_SLOTS`,
  [2048]: `DEV_ROOT_FRAGMENT`,
  [-1]: `HOISTED`,
  [-2]: `BAIL`
};
var slotFlagsText = {
  [1]: "STABLE",
  [2]: "DYNAMIC",
  [3]: "FORWARDED"
};
var specialBooleanAttrs = `itemscope,allowfullscreen,formnovalidate,ismap,nomodule,novalidate,readonly`;
var isBooleanAttr2 = /* @__PURE__ */ makeMap(specialBooleanAttrs + `,async,autofocus,autoplay,controls,default,defer,disabled,hidden,loop,open,required,reversed,scoped,seamless,checked,muted,multiple,selected`);
var EMPTY_OBJ =  true ? Object.freeze({}) : 0;
var EMPTY_ARR =  true ? Object.freeze([]) : 0;
var extend = Object.assign;
var hasOwnProperty = Object.prototype.hasOwnProperty;
var hasOwn = (val, key) => hasOwnProperty.call(val, key);
var isArray = Array.isArray;
var isMap = (val) => toTypeString(val) === "[object Map]";
var isString = (val) => typeof val === "string";
var isSymbol = (val) => typeof val === "symbol";
var isObject = (val) => val !== null && typeof val === "object";
var objectToString = Object.prototype.toString;
var toTypeString = (value) => objectToString.call(value);
var toRawType = (value) => {
  return toTypeString(value).slice(8, -1);
};
var isIntegerKey = (key) => isString(key) && key !== "NaN" && key[0] !== "-" && "" + parseInt(key, 10) === key;
var cacheStringFunction = (fn) => {
  const cache = Object.create(null);
  return (str) => {
    const hit = cache[str];
    return hit || (cache[str] = fn(str));
  };
};
var camelizeRE = /-(\w)/g;
var camelize = cacheStringFunction((str) => {
  return str.replace(camelizeRE, (_, c) => c ? c.toUpperCase() : "");
});
var hyphenateRE = /\B([A-Z])/g;
var hyphenate = cacheStringFunction((str) => str.replace(hyphenateRE, "-$1").toLowerCase());
var capitalize = cacheStringFunction((str) => str.charAt(0).toUpperCase() + str.slice(1));
var toHandlerKey = cacheStringFunction((str) => str ? `on${capitalize(str)}` : ``);
var hasChanged = (value, oldValue) => value !== oldValue && (value === value || oldValue === oldValue);

// node_modules/@vue/reactivity/dist/reactivity.esm-bundler.js
var targetMap = new WeakMap();
var effectStack = [];
var activeEffect;
var ITERATE_KEY = Symbol( true ? "iterate" : 0);
var MAP_KEY_ITERATE_KEY = Symbol( true ? "Map key iterate" : 0);
function isEffect(fn) {
  return fn && fn._isEffect === true;
}
function effect2(fn, options = EMPTY_OBJ) {
  if (isEffect(fn)) {
    fn = fn.raw;
  }
  const effect3 = createReactiveEffect(fn, options);
  if (!options.lazy) {
    effect3();
  }
  return effect3;
}
function stop(effect3) {
  if (effect3.active) {
    cleanup(effect3);
    if (effect3.options.onStop) {
      effect3.options.onStop();
    }
    effect3.active = false;
  }
}
var uid = 0;
function createReactiveEffect(fn, options) {
  const effect3 = function reactiveEffect() {
    if (!effect3.active) {
      return fn();
    }
    if (!effectStack.includes(effect3)) {
      cleanup(effect3);
      try {
        enableTracking();
        effectStack.push(effect3);
        activeEffect = effect3;
        return fn();
      } finally {
        effectStack.pop();
        resetTracking();
        activeEffect = effectStack[effectStack.length - 1];
      }
    }
  };
  effect3.id = uid++;
  effect3.allowRecurse = !!options.allowRecurse;
  effect3._isEffect = true;
  effect3.active = true;
  effect3.raw = fn;
  effect3.deps = [];
  effect3.options = options;
  return effect3;
}
function cleanup(effect3) {
  const {deps} = effect3;
  if (deps.length) {
    for (let i = 0; i < deps.length; i++) {
      deps[i].delete(effect3);
    }
    deps.length = 0;
  }
}
var shouldTrack = true;
var trackStack = [];
function pauseTracking() {
  trackStack.push(shouldTrack);
  shouldTrack = false;
}
function enableTracking() {
  trackStack.push(shouldTrack);
  shouldTrack = true;
}
function resetTracking() {
  const last = trackStack.pop();
  shouldTrack = last === void 0 ? true : last;
}
function track(target, type, key) {
  if (!shouldTrack || activeEffect === void 0) {
    return;
  }
  let depsMap = targetMap.get(target);
  if (!depsMap) {
    targetMap.set(target, depsMap = new Map());
  }
  let dep = depsMap.get(key);
  if (!dep) {
    depsMap.set(key, dep = new Set());
  }
  if (!dep.has(activeEffect)) {
    dep.add(activeEffect);
    activeEffect.deps.push(dep);
    if (activeEffect.options.onTrack) {
      activeEffect.options.onTrack({
        effect: activeEffect,
        target,
        type,
        key
      });
    }
  }
}
function trigger(target, type, key, newValue, oldValue, oldTarget) {
  const depsMap = targetMap.get(target);
  if (!depsMap) {
    return;
  }
  const effects = new Set();
  const add2 = (effectsToAdd) => {
    if (effectsToAdd) {
      effectsToAdd.forEach((effect3) => {
        if (effect3 !== activeEffect || effect3.allowRecurse) {
          effects.add(effect3);
        }
      });
    }
  };
  if (type === "clear") {
    depsMap.forEach(add2);
  } else if (key === "length" && isArray(target)) {
    depsMap.forEach((dep, key2) => {
      if (key2 === "length" || key2 >= newValue) {
        add2(dep);
      }
    });
  } else {
    if (key !== void 0) {
      add2(depsMap.get(key));
    }
    switch (type) {
      case "add":
        if (!isArray(target)) {
          add2(depsMap.get(ITERATE_KEY));
          if (isMap(target)) {
            add2(depsMap.get(MAP_KEY_ITERATE_KEY));
          }
        } else if (isIntegerKey(key)) {
          add2(depsMap.get("length"));
        }
        break;
      case "delete":
        if (!isArray(target)) {
          add2(depsMap.get(ITERATE_KEY));
          if (isMap(target)) {
            add2(depsMap.get(MAP_KEY_ITERATE_KEY));
          }
        }
        break;
      case "set":
        if (isMap(target)) {
          add2(depsMap.get(ITERATE_KEY));
        }
        break;
    }
  }
  const run = (effect3) => {
    if (effect3.options.onTrigger) {
      effect3.options.onTrigger({
        effect: effect3,
        target,
        key,
        type,
        newValue,
        oldValue,
        oldTarget
      });
    }
    if (effect3.options.scheduler) {
      effect3.options.scheduler(effect3);
    } else {
      effect3();
    }
  };
  effects.forEach(run);
}
var isNonTrackableKeys = /* @__PURE__ */ makeMap(`__proto__,__v_isRef,__isVue`);
var builtInSymbols = new Set(Object.getOwnPropertyNames(Symbol).map((key) => Symbol[key]).filter(isSymbol));
var get2 = /* @__PURE__ */ createGetter();
var shallowGet = /* @__PURE__ */ createGetter(false, true);
var readonlyGet = /* @__PURE__ */ createGetter(true);
var shallowReadonlyGet = /* @__PURE__ */ createGetter(true, true);
var arrayInstrumentations = {};
["includes", "indexOf", "lastIndexOf"].forEach((key) => {
  const method = Array.prototype[key];
  arrayInstrumentations[key] = function(...args) {
    const arr = toRaw(this);
    for (let i = 0, l = this.length; i < l; i++) {
      track(arr, "get", i + "");
    }
    const res = method.apply(arr, args);
    if (res === -1 || res === false) {
      return method.apply(arr, args.map(toRaw));
    } else {
      return res;
    }
  };
});
["push", "pop", "shift", "unshift", "splice"].forEach((key) => {
  const method = Array.prototype[key];
  arrayInstrumentations[key] = function(...args) {
    pauseTracking();
    const res = method.apply(this, args);
    resetTracking();
    return res;
  };
});
function createGetter(isReadonly = false, shallow = false) {
  return function get3(target, key, receiver) {
    if (key === "__v_isReactive") {
      return !isReadonly;
    } else if (key === "__v_isReadonly") {
      return isReadonly;
    } else if (key === "__v_raw" && receiver === (isReadonly ? shallow ? shallowReadonlyMap : readonlyMap : shallow ? shallowReactiveMap : reactiveMap).get(target)) {
      return target;
    }
    const targetIsArray = isArray(target);
    if (!isReadonly && targetIsArray && hasOwn(arrayInstrumentations, key)) {
      return Reflect.get(arrayInstrumentations, key, receiver);
    }
    const res = Reflect.get(target, key, receiver);
    if (isSymbol(key) ? builtInSymbols.has(key) : isNonTrackableKeys(key)) {
      return res;
    }
    if (!isReadonly) {
      track(target, "get", key);
    }
    if (shallow) {
      return res;
    }
    if (isRef(res)) {
      const shouldUnwrap = !targetIsArray || !isIntegerKey(key);
      return shouldUnwrap ? res.value : res;
    }
    if (isObject(res)) {
      return isReadonly ? readonly(res) : reactive2(res);
    }
    return res;
  };
}
var set2 = /* @__PURE__ */ createSetter();
var shallowSet = /* @__PURE__ */ createSetter(true);
function createSetter(shallow = false) {
  return function set3(target, key, value, receiver) {
    let oldValue = target[key];
    if (!shallow) {
      value = toRaw(value);
      oldValue = toRaw(oldValue);
      if (!isArray(target) && isRef(oldValue) && !isRef(value)) {
        oldValue.value = value;
        return true;
      }
    }
    const hadKey = isArray(target) && isIntegerKey(key) ? Number(key) < target.length : hasOwn(target, key);
    const result = Reflect.set(target, key, value, receiver);
    if (target === toRaw(receiver)) {
      if (!hadKey) {
        trigger(target, "add", key, value);
      } else if (hasChanged(value, oldValue)) {
        trigger(target, "set", key, value, oldValue);
      }
    }
    return result;
  };
}
function deleteProperty(target, key) {
  const hadKey = hasOwn(target, key);
  const oldValue = target[key];
  const result = Reflect.deleteProperty(target, key);
  if (result && hadKey) {
    trigger(target, "delete", key, void 0, oldValue);
  }
  return result;
}
function has(target, key) {
  const result = Reflect.has(target, key);
  if (!isSymbol(key) || !builtInSymbols.has(key)) {
    track(target, "has", key);
  }
  return result;
}
function ownKeys(target) {
  track(target, "iterate", isArray(target) ? "length" : ITERATE_KEY);
  return Reflect.ownKeys(target);
}
var mutableHandlers = {
  get: get2,
  set: set2,
  deleteProperty,
  has,
  ownKeys
};
var readonlyHandlers = {
  get: readonlyGet,
  set(target, key) {
    if (true) {
      console.warn(`Set operation on key "${String(key)}" failed: target is readonly.`, target);
    }
    return true;
  },
  deleteProperty(target, key) {
    if (true) {
      console.warn(`Delete operation on key "${String(key)}" failed: target is readonly.`, target);
    }
    return true;
  }
};
var shallowReactiveHandlers = extend({}, mutableHandlers, {
  get: shallowGet,
  set: shallowSet
});
var shallowReadonlyHandlers = extend({}, readonlyHandlers, {
  get: shallowReadonlyGet
});
var toReactive = (value) => isObject(value) ? reactive2(value) : value;
var toReadonly = (value) => isObject(value) ? readonly(value) : value;
var toShallow = (value) => value;
var getProto = (v) => Reflect.getPrototypeOf(v);
function get$1(target, key, isReadonly = false, isShallow = false) {
  target = target["__v_raw"];
  const rawTarget = toRaw(target);
  const rawKey = toRaw(key);
  if (key !== rawKey) {
    !isReadonly && track(rawTarget, "get", key);
  }
  !isReadonly && track(rawTarget, "get", rawKey);
  const {has: has2} = getProto(rawTarget);
  const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
  if (has2.call(rawTarget, key)) {
    return wrap(target.get(key));
  } else if (has2.call(rawTarget, rawKey)) {
    return wrap(target.get(rawKey));
  } else if (target !== rawTarget) {
    target.get(key);
  }
}
function has$1(key, isReadonly = false) {
  const target = this["__v_raw"];
  const rawTarget = toRaw(target);
  const rawKey = toRaw(key);
  if (key !== rawKey) {
    !isReadonly && track(rawTarget, "has", key);
  }
  !isReadonly && track(rawTarget, "has", rawKey);
  return key === rawKey ? target.has(key) : target.has(key) || target.has(rawKey);
}
function size(target, isReadonly = false) {
  target = target["__v_raw"];
  !isReadonly && track(toRaw(target), "iterate", ITERATE_KEY);
  return Reflect.get(target, "size", target);
}
function add(value) {
  value = toRaw(value);
  const target = toRaw(this);
  const proto = getProto(target);
  const hadKey = proto.has.call(target, value);
  if (!hadKey) {
    target.add(value);
    trigger(target, "add", value, value);
  }
  return this;
}
function set$1(key, value) {
  value = toRaw(value);
  const target = toRaw(this);
  const {has: has2, get: get3} = getProto(target);
  let hadKey = has2.call(target, key);
  if (!hadKey) {
    key = toRaw(key);
    hadKey = has2.call(target, key);
  } else if (true) {
    checkIdentityKeys(target, has2, key);
  }
  const oldValue = get3.call(target, key);
  target.set(key, value);
  if (!hadKey) {
    trigger(target, "add", key, value);
  } else if (hasChanged(value, oldValue)) {
    trigger(target, "set", key, value, oldValue);
  }
  return this;
}
function deleteEntry(key) {
  const target = toRaw(this);
  const {has: has2, get: get3} = getProto(target);
  let hadKey = has2.call(target, key);
  if (!hadKey) {
    key = toRaw(key);
    hadKey = has2.call(target, key);
  } else if (true) {
    checkIdentityKeys(target, has2, key);
  }
  const oldValue = get3 ? get3.call(target, key) : void 0;
  const result = target.delete(key);
  if (hadKey) {
    trigger(target, "delete", key, void 0, oldValue);
  }
  return result;
}
function clear() {
  const target = toRaw(this);
  const hadItems = target.size !== 0;
  const oldTarget =  true ? isMap(target) ? new Map(target) : new Set(target) : 0;
  const result = target.clear();
  if (hadItems) {
    trigger(target, "clear", void 0, void 0, oldTarget);
  }
  return result;
}
function createForEach(isReadonly, isShallow) {
  return function forEach(callback, thisArg) {
    const observed = this;
    const target = observed["__v_raw"];
    const rawTarget = toRaw(target);
    const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
    !isReadonly && track(rawTarget, "iterate", ITERATE_KEY);
    return target.forEach((value, key) => {
      return callback.call(thisArg, wrap(value), wrap(key), observed);
    });
  };
}
function createIterableMethod(method, isReadonly, isShallow) {
  return function(...args) {
    const target = this["__v_raw"];
    const rawTarget = toRaw(target);
    const targetIsMap = isMap(rawTarget);
    const isPair = method === "entries" || method === Symbol.iterator && targetIsMap;
    const isKeyOnly = method === "keys" && targetIsMap;
    const innerIterator = target[method](...args);
    const wrap = isShallow ? toShallow : isReadonly ? toReadonly : toReactive;
    !isReadonly && track(rawTarget, "iterate", isKeyOnly ? MAP_KEY_ITERATE_KEY : ITERATE_KEY);
    return {
      next() {
        const {value, done} = innerIterator.next();
        return done ? {value, done} : {
          value: isPair ? [wrap(value[0]), wrap(value[1])] : wrap(value),
          done
        };
      },
      [Symbol.iterator]() {
        return this;
      }
    };
  };
}
function createReadonlyMethod(type) {
  return function(...args) {
    if (true) {
      const key = args[0] ? `on key "${args[0]}" ` : ``;
      console.warn(`${capitalize(type)} operation ${key}failed: target is readonly.`, toRaw(this));
    }
    return type === "delete" ? false : this;
  };
}
var mutableInstrumentations = {
  get(key) {
    return get$1(this, key);
  },
  get size() {
    return size(this);
  },
  has: has$1,
  add,
  set: set$1,
  delete: deleteEntry,
  clear,
  forEach: createForEach(false, false)
};
var shallowInstrumentations = {
  get(key) {
    return get$1(this, key, false, true);
  },
  get size() {
    return size(this);
  },
  has: has$1,
  add,
  set: set$1,
  delete: deleteEntry,
  clear,
  forEach: createForEach(false, true)
};
var readonlyInstrumentations = {
  get(key) {
    return get$1(this, key, true);
  },
  get size() {
    return size(this, true);
  },
  has(key) {
    return has$1.call(this, key, true);
  },
  add: createReadonlyMethod("add"),
  set: createReadonlyMethod("set"),
  delete: createReadonlyMethod("delete"),
  clear: createReadonlyMethod("clear"),
  forEach: createForEach(true, false)
};
var shallowReadonlyInstrumentations = {
  get(key) {
    return get$1(this, key, true, true);
  },
  get size() {
    return size(this, true);
  },
  has(key) {
    return has$1.call(this, key, true);
  },
  add: createReadonlyMethod("add"),
  set: createReadonlyMethod("set"),
  delete: createReadonlyMethod("delete"),
  clear: createReadonlyMethod("clear"),
  forEach: createForEach(true, true)
};
var iteratorMethods = ["keys", "values", "entries", Symbol.iterator];
iteratorMethods.forEach((method) => {
  mutableInstrumentations[method] = createIterableMethod(method, false, false);
  readonlyInstrumentations[method] = createIterableMethod(method, true, false);
  shallowInstrumentations[method] = createIterableMethod(method, false, true);
  shallowReadonlyInstrumentations[method] = createIterableMethod(method, true, true);
});
function createInstrumentationGetter(isReadonly, shallow) {
  const instrumentations = shallow ? isReadonly ? shallowReadonlyInstrumentations : shallowInstrumentations : isReadonly ? readonlyInstrumentations : mutableInstrumentations;
  return (target, key, receiver) => {
    if (key === "__v_isReactive") {
      return !isReadonly;
    } else if (key === "__v_isReadonly") {
      return isReadonly;
    } else if (key === "__v_raw") {
      return target;
    }
    return Reflect.get(hasOwn(instrumentations, key) && key in target ? instrumentations : target, key, receiver);
  };
}
var mutableCollectionHandlers = {
  get: createInstrumentationGetter(false, false)
};
var shallowCollectionHandlers = {
  get: createInstrumentationGetter(false, true)
};
var readonlyCollectionHandlers = {
  get: createInstrumentationGetter(true, false)
};
var shallowReadonlyCollectionHandlers = {
  get: createInstrumentationGetter(true, true)
};
function checkIdentityKeys(target, has2, key) {
  const rawKey = toRaw(key);
  if (rawKey !== key && has2.call(target, rawKey)) {
    const type = toRawType(target);
    console.warn(`Reactive ${type} contains both the raw and reactive versions of the same object${type === `Map` ? ` as keys` : ``}, which can lead to inconsistencies. Avoid differentiating between the raw and reactive versions of an object and only use the reactive version if possible.`);
  }
}
var reactiveMap = new WeakMap();
var shallowReactiveMap = new WeakMap();
var readonlyMap = new WeakMap();
var shallowReadonlyMap = new WeakMap();
function targetTypeMap(rawType) {
  switch (rawType) {
    case "Object":
    case "Array":
      return 1;
    case "Map":
    case "Set":
    case "WeakMap":
    case "WeakSet":
      return 2;
    default:
      return 0;
  }
}
function getTargetType(value) {
  return value["__v_skip"] || !Object.isExtensible(value) ? 0 : targetTypeMap(toRawType(value));
}
function reactive2(target) {
  if (target && target["__v_isReadonly"]) {
    return target;
  }
  return createReactiveObject(target, false, mutableHandlers, mutableCollectionHandlers, reactiveMap);
}
function readonly(target) {
  return createReactiveObject(target, true, readonlyHandlers, readonlyCollectionHandlers, readonlyMap);
}
function createReactiveObject(target, isReadonly, baseHandlers, collectionHandlers, proxyMap) {
  if (!isObject(target)) {
    if (true) {
      console.warn(`value cannot be made reactive: ${String(target)}`);
    }
    return target;
  }
  if (target["__v_raw"] && !(isReadonly && target["__v_isReactive"])) {
    return target;
  }
  const existingProxy = proxyMap.get(target);
  if (existingProxy) {
    return existingProxy;
  }
  const targetType = getTargetType(target);
  if (targetType === 0) {
    return target;
  }
  const proxy = new Proxy(target, targetType === 2 ? collectionHandlers : baseHandlers);
  proxyMap.set(target, proxy);
  return proxy;
}
function toRaw(observed) {
  return observed && toRaw(observed["__v_raw"]) || observed;
}
function isRef(r) {
  return Boolean(r && r.__v_isRef === true);
}

// packages/alpinejs/src/magics/$nextTick.js
magic("nextTick", () => nextTick);

// packages/alpinejs/src/magics/$dispatch.js
magic("dispatch", (el) => dispatch.bind(dispatch, el));

// packages/alpinejs/src/magics/$watch.js
magic("watch", (el, {evaluateLater: evaluateLater2, effect: effect3}) => (key, callback) => {
  let evaluate2 = evaluateLater2(key);
  let firstTime = true;
  let oldValue;
  let effectReference = effect3(() => evaluate2((value) => {
    JSON.stringify(value);
    if (!firstTime) {
      queueMicrotask(() => {
        callback(value, oldValue);
        oldValue = value;
      });
    } else {
      oldValue = value;
    }
    firstTime = false;
  }));
  el._x_effects.delete(effectReference);
});

// packages/alpinejs/src/magics/$store.js
magic("store", getStores);

// packages/alpinejs/src/magics/$data.js
magic("data", (el) => scope(el));

// packages/alpinejs/src/magics/$root.js
magic("root", (el) => closestRoot(el));

// packages/alpinejs/src/magics/$refs.js
magic("refs", (el) => {
  if (el._x_refs_proxy)
    return el._x_refs_proxy;
  el._x_refs_proxy = mergeProxies(getArrayOfRefObject(el));
  return el._x_refs_proxy;
});
function getArrayOfRefObject(el) {
  let refObjects = [];
  let currentEl = el;
  while (currentEl) {
    if (currentEl._x_refs)
      refObjects.push(currentEl._x_refs);
    currentEl = currentEl.parentNode;
  }
  return refObjects;
}

// packages/alpinejs/src/ids.js
var globalIdMemo = {};
function findAndIncrementId(name) {
  if (!globalIdMemo[name])
    globalIdMemo[name] = 0;
  return ++globalIdMemo[name];
}
function closestIdRoot(el, name) {
  return findClosest(el, (element) => {
    if (element._x_ids && element._x_ids[name])
      return true;
  });
}
function setIdRoot(el, name) {
  if (!el._x_ids)
    el._x_ids = {};
  if (!el._x_ids[name])
    el._x_ids[name] = findAndIncrementId(name);
}

// packages/alpinejs/src/magics/$id.js
magic("id", (el) => (name, key = null) => {
  let root = closestIdRoot(el, name);
  let id = root ? root._x_ids[name] : findAndIncrementId(name);
  return key ? `${name}-${id}-${key}` : `${name}-${id}`;
});

// packages/alpinejs/src/magics/$el.js
magic("el", (el) => el);

// packages/alpinejs/src/magics/index.js
warnMissingPluginMagic("Focus", "focus", "focus");
warnMissingPluginMagic("Persist", "persist", "persist");
function warnMissingPluginMagic(name, magicName, slug) {
  magic(magicName, (el) => warn(`You can't use [$${directiveName}] without first installing the "${name}" plugin here: https://alpinejs.dev/plugins/${slug}`, el));
}

// packages/alpinejs/src/directives/x-modelable.js
directive("modelable", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let func = evaluateLater2(expression);
  let innerGet = () => {
    let result;
    func((i) => result = i);
    return result;
  };
  let evaluateInnerSet = evaluateLater2(`${expression} = __placeholder`);
  let innerSet = (val) => evaluateInnerSet(() => {
  }, {scope: {__placeholder: val}});
  let initialValue = innerGet();
  innerSet(initialValue);
  queueMicrotask(() => {
    if (!el._x_model)
      return;
    el._x_removeModelListeners["default"]();
    let outerGet = el._x_model.get;
    let outerSet = el._x_model.set;
    effect3(() => innerSet(outerGet()));
    effect3(() => outerSet(innerGet()));
  });
});

// packages/alpinejs/src/directives/x-teleport.js
directive("teleport", (el, {expression}, {cleanup: cleanup2}) => {
  if (el.tagName.toLowerCase() !== "template")
    warn("x-teleport can only be used on a <template> tag", el);
  let target = document.querySelector(expression);
  if (!target)
    warn(`Cannot find x-teleport element for selector: "${expression}"`);
  let clone2 = el.content.cloneNode(true).firstElementChild;
  el._x_teleport = clone2;
  clone2._x_teleportBack = el;
  if (el._x_forwardEvents) {
    el._x_forwardEvents.forEach((eventName) => {
      clone2.addEventListener(eventName, (e) => {
        e.stopPropagation();
        el.dispatchEvent(new e.constructor(e.type, e));
      });
    });
  }
  addScopeToNode(clone2, {}, el);
  mutateDom(() => {
    target.appendChild(clone2);
    initTree(clone2);
    clone2._x_ignore = true;
  });
  cleanup2(() => clone2.remove());
});

// packages/alpinejs/src/directives/x-ignore.js
var handler = () => {
};
handler.inline = (el, {modifiers}, {cleanup: cleanup2}) => {
  modifiers.includes("self") ? el._x_ignoreSelf = true : el._x_ignore = true;
  cleanup2(() => {
    modifiers.includes("self") ? delete el._x_ignoreSelf : delete el._x_ignore;
  });
};
directive("ignore", handler);

// packages/alpinejs/src/directives/x-effect.js
directive("effect", (el, {expression}, {effect: effect3}) => effect3(evaluateLater(el, expression)));

// packages/alpinejs/src/utils/on.js
function on(el, event, modifiers, callback) {
  let listenerTarget = el;
  let handler3 = (e) => callback(e);
  let options = {};
  let wrapHandler = (callback2, wrapper) => (e) => wrapper(callback2, e);
  if (modifiers.includes("dot"))
    event = dotSyntax(event);
  if (modifiers.includes("camel"))
    event = camelCase2(event);
  if (modifiers.includes("passive"))
    options.passive = true;
  if (modifiers.includes("capture"))
    options.capture = true;
  if (modifiers.includes("window"))
    listenerTarget = window;
  if (modifiers.includes("document"))
    listenerTarget = document;
  if (modifiers.includes("prevent"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.preventDefault();
      next(e);
    });
  if (modifiers.includes("stop"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.stopPropagation();
      next(e);
    });
  if (modifiers.includes("self"))
    handler3 = wrapHandler(handler3, (next, e) => {
      e.target === el && next(e);
    });
  if (modifiers.includes("away") || modifiers.includes("outside")) {
    listenerTarget = document;
    handler3 = wrapHandler(handler3, (next, e) => {
      if (el.contains(e.target))
        return;
      if (e.target.isConnected === false)
        return;
      if (el.offsetWidth < 1 && el.offsetHeight < 1)
        return;
      if (el._x_isShown === false)
        return;
      next(e);
    });
  }
  if (modifiers.includes("once")) {
    handler3 = wrapHandler(handler3, (next, e) => {
      next(e);
      listenerTarget.removeEventListener(event, handler3, options);
    });
  }
  handler3 = wrapHandler(handler3, (next, e) => {
    if (isKeyEvent(event)) {
      if (isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers)) {
        return;
      }
    }
    next(e);
  });
  if (modifiers.includes("debounce")) {
    let nextModifier = modifiers[modifiers.indexOf("debounce") + 1] || "invalid-wait";
    let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
    handler3 = debounce(handler3, wait);
  }
  if (modifiers.includes("throttle")) {
    let nextModifier = modifiers[modifiers.indexOf("throttle") + 1] || "invalid-wait";
    let wait = isNumeric(nextModifier.split("ms")[0]) ? Number(nextModifier.split("ms")[0]) : 250;
    handler3 = throttle(handler3, wait);
  }
  listenerTarget.addEventListener(event, handler3, options);
  return () => {
    listenerTarget.removeEventListener(event, handler3, options);
  };
}
function dotSyntax(subject) {
  return subject.replace(/-/g, ".");
}
function camelCase2(subject) {
  return subject.toLowerCase().replace(/-(\w)/g, (match, char) => char.toUpperCase());
}
function isNumeric(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}
function kebabCase2(subject) {
  return subject.replace(/([a-z])([A-Z])/g, "$1-$2").replace(/[_\s]/, "-").toLowerCase();
}
function isKeyEvent(event) {
  return ["keydown", "keyup"].includes(event);
}
function isListeningForASpecificKeyThatHasntBeenPressed(e, modifiers) {
  let keyModifiers = modifiers.filter((i) => {
    return !["window", "document", "prevent", "stop", "once"].includes(i);
  });
  if (keyModifiers.includes("debounce")) {
    let debounceIndex = keyModifiers.indexOf("debounce");
    keyModifiers.splice(debounceIndex, isNumeric((keyModifiers[debounceIndex + 1] || "invalid-wait").split("ms")[0]) ? 2 : 1);
  }
  if (keyModifiers.length === 0)
    return false;
  if (keyModifiers.length === 1 && keyToModifiers(e.key).includes(keyModifiers[0]))
    return false;
  const systemKeyModifiers = ["ctrl", "shift", "alt", "meta", "cmd", "super"];
  const selectedSystemKeyModifiers = systemKeyModifiers.filter((modifier) => keyModifiers.includes(modifier));
  keyModifiers = keyModifiers.filter((i) => !selectedSystemKeyModifiers.includes(i));
  if (selectedSystemKeyModifiers.length > 0) {
    const activelyPressedKeyModifiers = selectedSystemKeyModifiers.filter((modifier) => {
      if (modifier === "cmd" || modifier === "super")
        modifier = "meta";
      return e[`${modifier}Key`];
    });
    if (activelyPressedKeyModifiers.length === selectedSystemKeyModifiers.length) {
      if (keyToModifiers(e.key).includes(keyModifiers[0]))
        return false;
    }
  }
  return true;
}
function keyToModifiers(key) {
  if (!key)
    return [];
  key = kebabCase2(key);
  let modifierToKeyMap = {
    ctrl: "control",
    slash: "/",
    space: "-",
    spacebar: "-",
    cmd: "meta",
    esc: "escape",
    up: "arrow-up",
    down: "arrow-down",
    left: "arrow-left",
    right: "arrow-right",
    period: ".",
    equal: "="
  };
  modifierToKeyMap[key] = key;
  return Object.keys(modifierToKeyMap).map((modifier) => {
    if (modifierToKeyMap[modifier] === key)
      return modifier;
  }).filter((modifier) => modifier);
}

// packages/alpinejs/src/directives/x-model.js
directive("model", (el, {modifiers, expression}, {effect: effect3, cleanup: cleanup2}) => {
  let evaluate2 = evaluateLater(el, expression);
  let assignmentExpression = `${expression} = rightSideOfExpression($event, ${expression})`;
  let evaluateAssignment = evaluateLater(el, assignmentExpression);
  var event = el.tagName.toLowerCase() === "select" || ["checkbox", "radio"].includes(el.type) || modifiers.includes("lazy") ? "change" : "input";
  let assigmentFunction = generateAssignmentFunction(el, modifiers, expression);
  let removeListener = on(el, event, modifiers, (e) => {
    evaluateAssignment(() => {
    }, {scope: {
      $event: e,
      rightSideOfExpression: assigmentFunction
    }});
  });
  if (!el._x_removeModelListeners)
    el._x_removeModelListeners = {};
  el._x_removeModelListeners["default"] = removeListener;
  cleanup2(() => el._x_removeModelListeners["default"]());
  let evaluateSetModel = evaluateLater(el, `${expression} = __placeholder`);
  el._x_model = {
    get() {
      let result;
      evaluate2((value) => result = value);
      return result;
    },
    set(value) {
      evaluateSetModel(() => {
      }, {scope: {__placeholder: value}});
    }
  };
  el._x_forceModelUpdate = () => {
    evaluate2((value) => {
      if (value === void 0 && expression.match(/\./))
        value = "";
      window.fromModel = true;
      mutateDom(() => bind(el, "value", value));
      delete window.fromModel;
    });
  };
  effect3(() => {
    if (modifiers.includes("unintrusive") && document.activeElement.isSameNode(el))
      return;
    el._x_forceModelUpdate();
  });
});
function generateAssignmentFunction(el, modifiers, expression) {
  if (el.type === "radio") {
    mutateDom(() => {
      if (!el.hasAttribute("name"))
        el.setAttribute("name", expression);
    });
  }
  return (event, currentValue) => {
    return mutateDom(() => {
      if (event instanceof CustomEvent && event.detail !== void 0) {
        return event.detail || event.target.value;
      } else if (el.type === "checkbox") {
        if (Array.isArray(currentValue)) {
          let newValue = modifiers.includes("number") ? safeParseNumber(event.target.value) : event.target.value;
          return event.target.checked ? currentValue.concat([newValue]) : currentValue.filter((el2) => !checkedAttrLooseCompare2(el2, newValue));
        } else {
          return event.target.checked;
        }
      } else if (el.tagName.toLowerCase() === "select" && el.multiple) {
        return modifiers.includes("number") ? Array.from(event.target.selectedOptions).map((option) => {
          let rawValue = option.value || option.text;
          return safeParseNumber(rawValue);
        }) : Array.from(event.target.selectedOptions).map((option) => {
          return option.value || option.text;
        });
      } else {
        let rawValue = event.target.value;
        return modifiers.includes("number") ? safeParseNumber(rawValue) : modifiers.includes("trim") ? rawValue.trim() : rawValue;
      }
    });
  };
}
function safeParseNumber(rawValue) {
  let number = rawValue ? parseFloat(rawValue) : null;
  return isNumeric2(number) ? number : rawValue;
}
function checkedAttrLooseCompare2(valueA, valueB) {
  return valueA == valueB;
}
function isNumeric2(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}

// packages/alpinejs/src/directives/x-cloak.js
directive("cloak", (el) => queueMicrotask(() => mutateDom(() => el.removeAttribute(prefix("cloak")))));

// packages/alpinejs/src/directives/x-init.js
addInitSelector(() => `[${prefix("init")}]`);
directive("init", skipDuringClone((el, {expression}, {evaluate: evaluate2}) => {
  if (typeof expression === "string") {
    return !!expression.trim() && evaluate2(expression, {}, false);
  }
  return evaluate2(expression, {}, false);
}));

// packages/alpinejs/src/directives/x-text.js
directive("text", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let evaluate2 = evaluateLater2(expression);
  effect3(() => {
    evaluate2((value) => {
      mutateDom(() => {
        el.textContent = value;
      });
    });
  });
});

// packages/alpinejs/src/directives/x-html.js
directive("html", (el, {expression}, {effect: effect3, evaluateLater: evaluateLater2}) => {
  let evaluate2 = evaluateLater2(expression);
  effect3(() => {
    evaluate2((value) => {
      mutateDom(() => {
        el.innerHTML = value;
        el._x_ignoreSelf = true;
        initTree(el);
        delete el._x_ignoreSelf;
      });
    });
  });
});

// packages/alpinejs/src/directives/x-bind.js
mapAttributes(startingWith(":", into(prefix("bind:"))));
directive("bind", (el, {value, modifiers, expression, original}, {effect: effect3}) => {
  if (!value) {
    let bindingProviders = {};
    injectBindingProviders(bindingProviders);
    let getBindings = evaluateLater(el, expression);
    getBindings((bindings) => {
      applyBindingsObject(el, bindings, original);
    }, {scope: bindingProviders});
    return;
  }
  if (value === "key")
    return storeKeyForXFor(el, expression);
  let evaluate2 = evaluateLater(el, expression);
  effect3(() => evaluate2((result) => {
    if (result === void 0 && typeof expression === "string" && expression.match(/\./)) {
      result = "";
    }
    mutateDom(() => bind(el, value, result, modifiers));
  }));
});
function storeKeyForXFor(el, expression) {
  el._x_keyExpression = expression;
}

// packages/alpinejs/src/directives/x-data.js
addRootSelector(() => `[${prefix("data")}]`);
directive("data", skipDuringClone((el, {expression}, {cleanup: cleanup2}) => {
  expression = expression === "" ? "{}" : expression;
  let magicContext = {};
  injectMagics(magicContext, el);
  let dataProviderContext = {};
  injectDataProviders(dataProviderContext, magicContext);
  let data2 = evaluate(el, expression, {scope: dataProviderContext});
  if (data2 === void 0)
    data2 = {};
  injectMagics(data2, el);
  let reactiveData = reactive(data2);
  initInterceptors(reactiveData);
  let undo = addScopeToNode(el, reactiveData);
  reactiveData["init"] && evaluate(el, reactiveData["init"]);
  cleanup2(() => {
    reactiveData["destroy"] && evaluate(el, reactiveData["destroy"]);
    undo();
  });
}));

// packages/alpinejs/src/directives/x-show.js
directive("show", (el, {modifiers, expression}, {effect: effect3}) => {
  let evaluate2 = evaluateLater(el, expression);
  if (!el._x_doHide)
    el._x_doHide = () => {
      mutateDom(() => {
        el.style.setProperty("display", "none", modifiers.includes("important") ? "important" : void 0);
      });
    };
  if (!el._x_doShow)
    el._x_doShow = () => {
      mutateDom(() => {
        if (el.style.length === 1 && el.style.display === "none") {
          el.removeAttribute("style");
        } else {
          el.style.removeProperty("display");
        }
      });
    };
  let hide = () => {
    el._x_doHide();
    el._x_isShown = false;
  };
  let show = () => {
    el._x_doShow();
    el._x_isShown = true;
  };
  let clickAwayCompatibleShow = () => setTimeout(show);
  let toggle = once((value) => value ? show() : hide(), (value) => {
    if (typeof el._x_toggleAndCascadeWithTransitions === "function") {
      el._x_toggleAndCascadeWithTransitions(el, value, show, hide);
    } else {
      value ? clickAwayCompatibleShow() : hide();
    }
  });
  let oldValue;
  let firstTime = true;
  effect3(() => evaluate2((value) => {
    if (!firstTime && value === oldValue)
      return;
    if (modifiers.includes("immediate"))
      value ? clickAwayCompatibleShow() : hide();
    toggle(value);
    oldValue = value;
    firstTime = false;
  }));
});

// packages/alpinejs/src/directives/x-for.js
directive("for", (el, {expression}, {effect: effect3, cleanup: cleanup2}) => {
  let iteratorNames = parseForExpression(expression);
  let evaluateItems = evaluateLater(el, iteratorNames.items);
  let evaluateKey = evaluateLater(el, el._x_keyExpression || "index");
  el._x_prevKeys = [];
  el._x_lookup = {};
  effect3(() => loop(el, iteratorNames, evaluateItems, evaluateKey));
  cleanup2(() => {
    Object.values(el._x_lookup).forEach((el2) => el2.remove());
    delete el._x_prevKeys;
    delete el._x_lookup;
  });
});
function loop(el, iteratorNames, evaluateItems, evaluateKey) {
  let isObject2 = (i) => typeof i === "object" && !Array.isArray(i);
  let templateEl = el;
  evaluateItems((items) => {
    if (isNumeric3(items) && items >= 0) {
      items = Array.from(Array(items).keys(), (i) => i + 1);
    }
    if (items === void 0)
      items = [];
    let lookup = el._x_lookup;
    let prevKeys = el._x_prevKeys;
    let scopes = [];
    let keys = [];
    if (isObject2(items)) {
      items = Object.entries(items).map(([key, value]) => {
        let scope2 = getIterationScopeVariables(iteratorNames, value, key, items);
        evaluateKey((value2) => keys.push(value2), {scope: {index: key, ...scope2}});
        scopes.push(scope2);
      });
    } else {
      for (let i = 0; i < items.length; i++) {
        let scope2 = getIterationScopeVariables(iteratorNames, items[i], i, items);
        evaluateKey((value) => keys.push(value), {scope: {index: i, ...scope2}});
        scopes.push(scope2);
      }
    }
    let adds = [];
    let moves = [];
    let removes = [];
    let sames = [];
    for (let i = 0; i < prevKeys.length; i++) {
      let key = prevKeys[i];
      if (keys.indexOf(key) === -1)
        removes.push(key);
    }
    prevKeys = prevKeys.filter((key) => !removes.includes(key));
    let lastKey = "template";
    for (let i = 0; i < keys.length; i++) {
      let key = keys[i];
      let prevIndex = prevKeys.indexOf(key);
      if (prevIndex === -1) {
        prevKeys.splice(i, 0, key);
        adds.push([lastKey, i]);
      } else if (prevIndex !== i) {
        let keyInSpot = prevKeys.splice(i, 1)[0];
        let keyForSpot = prevKeys.splice(prevIndex - 1, 1)[0];
        prevKeys.splice(i, 0, keyForSpot);
        prevKeys.splice(prevIndex, 0, keyInSpot);
        moves.push([keyInSpot, keyForSpot]);
      } else {
        sames.push(key);
      }
      lastKey = key;
    }
    for (let i = 0; i < removes.length; i++) {
      let key = removes[i];
      if (!!lookup[key]._x_effects) {
        lookup[key]._x_effects.forEach(dequeueJob);
      }
      lookup[key].remove();
      lookup[key] = null;
      delete lookup[key];
    }
    for (let i = 0; i < moves.length; i++) {
      let [keyInSpot, keyForSpot] = moves[i];
      let elInSpot = lookup[keyInSpot];
      let elForSpot = lookup[keyForSpot];
      let marker = document.createElement("div");
      mutateDom(() => {
        elForSpot.after(marker);
        elInSpot.after(elForSpot);
        elForSpot._x_currentIfEl && elForSpot.after(elForSpot._x_currentIfEl);
        marker.before(elInSpot);
        elInSpot._x_currentIfEl && elInSpot.after(elInSpot._x_currentIfEl);
        marker.remove();
      });
      refreshScope(elForSpot, scopes[keys.indexOf(keyForSpot)]);
    }
    for (let i = 0; i < adds.length; i++) {
      let [lastKey2, index] = adds[i];
      let lastEl = lastKey2 === "template" ? templateEl : lookup[lastKey2];
      if (lastEl._x_currentIfEl)
        lastEl = lastEl._x_currentIfEl;
      let scope2 = scopes[index];
      let key = keys[index];
      let clone2 = document.importNode(templateEl.content, true).firstElementChild;
      addScopeToNode(clone2, reactive(scope2), templateEl);
      mutateDom(() => {
        lastEl.after(clone2);
        initTree(clone2);
      });
      if (typeof key === "object") {
        warn("x-for key cannot be an object, it must be a string or an integer", templateEl);
      }
      lookup[key] = clone2;
    }
    for (let i = 0; i < sames.length; i++) {
      refreshScope(lookup[sames[i]], scopes[keys.indexOf(sames[i])]);
    }
    templateEl._x_prevKeys = keys;
  });
}
function parseForExpression(expression) {
  let forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
  let stripParensRE = /^\s*\(|\)\s*$/g;
  let forAliasRE = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/;
  let inMatch = expression.match(forAliasRE);
  if (!inMatch)
    return;
  let res = {};
  res.items = inMatch[2].trim();
  let item = inMatch[1].replace(stripParensRE, "").trim();
  let iteratorMatch = item.match(forIteratorRE);
  if (iteratorMatch) {
    res.item = item.replace(forIteratorRE, "").trim();
    res.index = iteratorMatch[1].trim();
    if (iteratorMatch[2]) {
      res.collection = iteratorMatch[2].trim();
    }
  } else {
    res.item = item;
  }
  return res;
}
function getIterationScopeVariables(iteratorNames, item, index, items) {
  let scopeVariables = {};
  if (/^\[.*\]$/.test(iteratorNames.item) && Array.isArray(item)) {
    let names = iteratorNames.item.replace("[", "").replace("]", "").split(",").map((i) => i.trim());
    names.forEach((name, i) => {
      scopeVariables[name] = item[i];
    });
  } else if (/^\{.*\}$/.test(iteratorNames.item) && !Array.isArray(item) && typeof item === "object") {
    let names = iteratorNames.item.replace("{", "").replace("}", "").split(",").map((i) => i.trim());
    names.forEach((name) => {
      scopeVariables[name] = item[name];
    });
  } else {
    scopeVariables[iteratorNames.item] = item;
  }
  if (iteratorNames.index)
    scopeVariables[iteratorNames.index] = index;
  if (iteratorNames.collection)
    scopeVariables[iteratorNames.collection] = items;
  return scopeVariables;
}
function isNumeric3(subject) {
  return !Array.isArray(subject) && !isNaN(subject);
}

// packages/alpinejs/src/directives/x-ref.js
function handler2() {
}
handler2.inline = (el, {expression}, {cleanup: cleanup2}) => {
  let root = closestRoot(el);
  if (!root._x_refs)
    root._x_refs = {};
  root._x_refs[expression] = el;
  cleanup2(() => delete root._x_refs[expression]);
};
directive("ref", handler2);

// packages/alpinejs/src/directives/x-if.js
directive("if", (el, {expression}, {effect: effect3, cleanup: cleanup2}) => {
  let evaluate2 = evaluateLater(el, expression);
  let show = () => {
    if (el._x_currentIfEl)
      return el._x_currentIfEl;
    let clone2 = el.content.cloneNode(true).firstElementChild;
    addScopeToNode(clone2, {}, el);
    mutateDom(() => {
      el.after(clone2);
      initTree(clone2);
    });
    el._x_currentIfEl = clone2;
    el._x_undoIf = () => {
      walk(clone2, (node) => {
        if (!!node._x_effects) {
          node._x_effects.forEach(dequeueJob);
        }
      });
      clone2.remove();
      delete el._x_currentIfEl;
    };
    return clone2;
  };
  let hide = () => {
    if (!el._x_undoIf)
      return;
    el._x_undoIf();
    delete el._x_undoIf;
  };
  effect3(() => evaluate2((value) => {
    value ? show() : hide();
  }));
  cleanup2(() => el._x_undoIf && el._x_undoIf());
});

// packages/alpinejs/src/directives/x-id.js
directive("id", (el, {expression}, {evaluate: evaluate2}) => {
  let names = evaluate2(expression);
  names.forEach((name) => setIdRoot(el, name));
});

// packages/alpinejs/src/directives/x-on.js
mapAttributes(startingWith("@", into(prefix("on:"))));
directive("on", skipDuringClone((el, {value, modifiers, expression}, {cleanup: cleanup2}) => {
  let evaluate2 = expression ? evaluateLater(el, expression) : () => {
  };
  if (el.tagName.toLowerCase() === "template") {
    if (!el._x_forwardEvents)
      el._x_forwardEvents = [];
    if (!el._x_forwardEvents.includes(value))
      el._x_forwardEvents.push(value);
  }
  let removeListener = on(el, value, modifiers, (e) => {
    evaluate2(() => {
    }, {scope: {$event: e}, params: [e]});
  });
  cleanup2(() => removeListener());
}));

// packages/alpinejs/src/directives/index.js
warnMissingPluginDirective("Collapse", "collapse", "collapse");
warnMissingPluginDirective("Intersect", "intersect", "intersect");
warnMissingPluginDirective("Focus", "trap", "focus");
warnMissingPluginDirective("Mask", "mask", "mask");
function warnMissingPluginDirective(name, directiveName2, slug) {
  directive(directiveName2, (el) => warn(`You can't use [x-${directiveName2}] without first installing the "${name}" plugin here: https://alpinejs.dev/plugins/${slug}`, el));
}

// packages/alpinejs/src/index.js
alpine_default.setEvaluator(normalEvaluator);
alpine_default.setReactivityEngine({reactive: reactive2, effect: effect2, release: stop, raw: toRaw});
var src_default = alpine_default;

// packages/alpinejs/builds/module.js
var module_default = src_default;



/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var dropzone__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! dropzone */ "./node_modules/dropzone/dist/dropzone.mjs");
/* harmony import */ var _fortawesome_fontawesome_free_scss_fontawesome_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @fortawesome/fontawesome-free/scss/fontawesome.scss */ "./node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss");
/* harmony import */ var _fortawesome_fontawesome_free_scss_brands_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @fortawesome/fontawesome-free/scss/brands.scss */ "./node_modules/@fortawesome/fontawesome-free/scss/brands.scss");
/* harmony import */ var _fortawesome_fontawesome_free_scss_regular_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @fortawesome/fontawesome-free/scss/regular.scss */ "./node_modules/@fortawesome/fontawesome-free/scss/regular.scss");
/* harmony import */ var _fortawesome_fontawesome_free_scss_solid_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @fortawesome/fontawesome-free/scss/solid.scss */ "./node_modules/@fortawesome/fontawesome-free/scss/solid.scss");
/* harmony import */ var _fortawesome_fontawesome_free_scss_v4_shims_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fortawesome/fontawesome-free/scss/v4-shims.scss */ "./node_modules/@fortawesome/fontawesome-free/scss/v4-shims.scss");
/* harmony import */ var alpinejs__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! alpinejs */ "./node_modules/alpinejs/dist/module.esm.js");

// import '../css/app.css';
//sweetalert2
window.Swal = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");

//instalación de fontawesomw






//dropzone
dropzone__WEBPACK_IMPORTED_MODULE_0__.Dropzone.autoDiscover = false;

//Alpine

window.Alpine = alpinejs__WEBPACK_IMPORTED_MODULE_6__["default"];
alpinejs__WEBPACK_IMPORTED_MODULE_6__["default"].start();

//dropzone clases
window.addEventListener('DOMContentLoaded', function () {
  var dropzone = new dropzone__WEBPACK_IMPORTED_MODULE_0__.Dropzone("#dropzone", {
    dictDefaultMessage: "Sube tu imagen del libro",
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,
    // funcion para no borrar imagen si se actualiza el formulario
    init: function init() {
      if (document.querySelector('[name="imagen"]').value.trim()) {
        //crear un objeto imagen temporal con tamaño y nombre
        var imagenPublicada = {};
        imagenPublicada.size = 1000;
        imagenPublicada.name = document.querySelector('[name="imagen"]').value;

        //funciones de dropzone para pasar la img publicada
        this.options.addedfile.call(this, imagenPublicada);
        // extraer la imagen publicada previamente
        this.options.thumbnail.call(this, imagenPublicada, " /uploads/".concat(imagenPublicada.name));
        //clases de dropzone
        imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
      }
    }
  });

  //respuesta de subida de imagen
  dropzone.on("success", function (file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;
  });
  dropzone.on("removedfile", function () {
    // resetar el campo imagen si no se usa
    document.querySelector('[name="imagen"]').value = "";
  });
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/brands.scss":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/brands.scss ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/getUrl.js */ "./node_modules/css-loader/dist/runtime/getUrl.js");
/* harmony import */ var _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _webfonts_fa_brands_400_woff2__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../webfonts/fa-brands-400.woff2 */ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.woff2");
/* harmony import */ var _webfonts_fa_brands_400_ttf__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../webfonts/fa-brands-400.ttf */ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.ttf");
// Imports




var ___CSS_LOADER_EXPORT___ = _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
var ___CSS_LOADER_URL_REPLACEMENT_0___ = _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default()(_webfonts_fa_brands_400_woff2__WEBPACK_IMPORTED_MODULE_2__["default"]);
var ___CSS_LOADER_URL_REPLACEMENT_1___ = _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default()(_webfonts_fa_brands_400_ttf__WEBPACK_IMPORTED_MODULE_3__["default"]);
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/*!\n * Font Awesome Free 6.2.0 by @fontawesome - https://fontawesome.com\n * License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)\n * Copyright 2022 Fonticons, Inc.\n */\n:root, :host {\n  --fa-style-family-brands: \"Font Awesome 6 Brands\";\n  --fa-font-brands: normal 400 1em/1 \"Font Awesome 6 Brands\";\n}\n\n@font-face {\n  font-family: \"Font Awesome 6 Brands\";\n  font-style: normal;\n  font-weight: 400;\n  font-display: block;\n  src: url(" + ___CSS_LOADER_URL_REPLACEMENT_0___ + ") format(\"woff2\"), url(" + ___CSS_LOADER_URL_REPLACEMENT_1___ + ") format(\"truetype\");\n}\n.fab,\n.fa-brands {\n  font-weight: 400;\n}\n\n.fa-monero:before {\n  content: \"\\f3d0\";\n}\n\n.fa-hooli:before {\n  content: \"\\f427\";\n}\n\n.fa-yelp:before {\n  content: \"\\f1e9\";\n}\n\n.fa-cc-visa:before {\n  content: \"\\f1f0\";\n}\n\n.fa-lastfm:before {\n  content: \"\\f202\";\n}\n\n.fa-shopware:before {\n  content: \"\\f5b5\";\n}\n\n.fa-creative-commons-nc:before {\n  content: \"\\f4e8\";\n}\n\n.fa-aws:before {\n  content: \"\\f375\";\n}\n\n.fa-redhat:before {\n  content: \"\\f7bc\";\n}\n\n.fa-yoast:before {\n  content: \"\\f2b1\";\n}\n\n.fa-cloudflare:before {\n  content: \"\\e07d\";\n}\n\n.fa-ups:before {\n  content: \"\\f7e0\";\n}\n\n.fa-wpexplorer:before {\n  content: \"\\f2de\";\n}\n\n.fa-dyalog:before {\n  content: \"\\f399\";\n}\n\n.fa-bity:before {\n  content: \"\\f37a\";\n}\n\n.fa-stackpath:before {\n  content: \"\\f842\";\n}\n\n.fa-buysellads:before {\n  content: \"\\f20d\";\n}\n\n.fa-first-order:before {\n  content: \"\\f2b0\";\n}\n\n.fa-modx:before {\n  content: \"\\f285\";\n}\n\n.fa-guilded:before {\n  content: \"\\e07e\";\n}\n\n.fa-vnv:before {\n  content: \"\\f40b\";\n}\n\n.fa-square-js:before {\n  content: \"\\f3b9\";\n}\n\n.fa-js-square:before {\n  content: \"\\f3b9\";\n}\n\n.fa-microsoft:before {\n  content: \"\\f3ca\";\n}\n\n.fa-qq:before {\n  content: \"\\f1d6\";\n}\n\n.fa-orcid:before {\n  content: \"\\f8d2\";\n}\n\n.fa-java:before {\n  content: \"\\f4e4\";\n}\n\n.fa-invision:before {\n  content: \"\\f7b0\";\n}\n\n.fa-creative-commons-pd-alt:before {\n  content: \"\\f4ed\";\n}\n\n.fa-centercode:before {\n  content: \"\\f380\";\n}\n\n.fa-glide-g:before {\n  content: \"\\f2a6\";\n}\n\n.fa-drupal:before {\n  content: \"\\f1a9\";\n}\n\n.fa-hire-a-helper:before {\n  content: \"\\f3b0\";\n}\n\n.fa-creative-commons-by:before {\n  content: \"\\f4e7\";\n}\n\n.fa-unity:before {\n  content: \"\\e049\";\n}\n\n.fa-whmcs:before {\n  content: \"\\f40d\";\n}\n\n.fa-rocketchat:before {\n  content: \"\\f3e8\";\n}\n\n.fa-vk:before {\n  content: \"\\f189\";\n}\n\n.fa-untappd:before {\n  content: \"\\f405\";\n}\n\n.fa-mailchimp:before {\n  content: \"\\f59e\";\n}\n\n.fa-css3-alt:before {\n  content: \"\\f38b\";\n}\n\n.fa-square-reddit:before {\n  content: \"\\f1a2\";\n}\n\n.fa-reddit-square:before {\n  content: \"\\f1a2\";\n}\n\n.fa-vimeo-v:before {\n  content: \"\\f27d\";\n}\n\n.fa-contao:before {\n  content: \"\\f26d\";\n}\n\n.fa-square-font-awesome:before {\n  content: \"\\e5ad\";\n}\n\n.fa-deskpro:before {\n  content: \"\\f38f\";\n}\n\n.fa-sistrix:before {\n  content: \"\\f3ee\";\n}\n\n.fa-square-instagram:before {\n  content: \"\\e055\";\n}\n\n.fa-instagram-square:before {\n  content: \"\\e055\";\n}\n\n.fa-battle-net:before {\n  content: \"\\f835\";\n}\n\n.fa-the-red-yeti:before {\n  content: \"\\f69d\";\n}\n\n.fa-square-hacker-news:before {\n  content: \"\\f3af\";\n}\n\n.fa-hacker-news-square:before {\n  content: \"\\f3af\";\n}\n\n.fa-edge:before {\n  content: \"\\f282\";\n}\n\n.fa-napster:before {\n  content: \"\\f3d2\";\n}\n\n.fa-square-snapchat:before {\n  content: \"\\f2ad\";\n}\n\n.fa-snapchat-square:before {\n  content: \"\\f2ad\";\n}\n\n.fa-google-plus-g:before {\n  content: \"\\f0d5\";\n}\n\n.fa-artstation:before {\n  content: \"\\f77a\";\n}\n\n.fa-markdown:before {\n  content: \"\\f60f\";\n}\n\n.fa-sourcetree:before {\n  content: \"\\f7d3\";\n}\n\n.fa-google-plus:before {\n  content: \"\\f2b3\";\n}\n\n.fa-diaspora:before {\n  content: \"\\f791\";\n}\n\n.fa-foursquare:before {\n  content: \"\\f180\";\n}\n\n.fa-stack-overflow:before {\n  content: \"\\f16c\";\n}\n\n.fa-github-alt:before {\n  content: \"\\f113\";\n}\n\n.fa-phoenix-squadron:before {\n  content: \"\\f511\";\n}\n\n.fa-pagelines:before {\n  content: \"\\f18c\";\n}\n\n.fa-algolia:before {\n  content: \"\\f36c\";\n}\n\n.fa-red-river:before {\n  content: \"\\f3e3\";\n}\n\n.fa-creative-commons-sa:before {\n  content: \"\\f4ef\";\n}\n\n.fa-safari:before {\n  content: \"\\f267\";\n}\n\n.fa-google:before {\n  content: \"\\f1a0\";\n}\n\n.fa-square-font-awesome-stroke:before {\n  content: \"\\f35c\";\n}\n\n.fa-font-awesome-alt:before {\n  content: \"\\f35c\";\n}\n\n.fa-atlassian:before {\n  content: \"\\f77b\";\n}\n\n.fa-linkedin-in:before {\n  content: \"\\f0e1\";\n}\n\n.fa-digital-ocean:before {\n  content: \"\\f391\";\n}\n\n.fa-nimblr:before {\n  content: \"\\f5a8\";\n}\n\n.fa-chromecast:before {\n  content: \"\\f838\";\n}\n\n.fa-evernote:before {\n  content: \"\\f839\";\n}\n\n.fa-hacker-news:before {\n  content: \"\\f1d4\";\n}\n\n.fa-creative-commons-sampling:before {\n  content: \"\\f4f0\";\n}\n\n.fa-adversal:before {\n  content: \"\\f36a\";\n}\n\n.fa-creative-commons:before {\n  content: \"\\f25e\";\n}\n\n.fa-watchman-monitoring:before {\n  content: \"\\e087\";\n}\n\n.fa-fonticons:before {\n  content: \"\\f280\";\n}\n\n.fa-weixin:before {\n  content: \"\\f1d7\";\n}\n\n.fa-shirtsinbulk:before {\n  content: \"\\f214\";\n}\n\n.fa-codepen:before {\n  content: \"\\f1cb\";\n}\n\n.fa-git-alt:before {\n  content: \"\\f841\";\n}\n\n.fa-lyft:before {\n  content: \"\\f3c3\";\n}\n\n.fa-rev:before {\n  content: \"\\f5b2\";\n}\n\n.fa-windows:before {\n  content: \"\\f17a\";\n}\n\n.fa-wizards-of-the-coast:before {\n  content: \"\\f730\";\n}\n\n.fa-square-viadeo:before {\n  content: \"\\f2aa\";\n}\n\n.fa-viadeo-square:before {\n  content: \"\\f2aa\";\n}\n\n.fa-meetup:before {\n  content: \"\\f2e0\";\n}\n\n.fa-centos:before {\n  content: \"\\f789\";\n}\n\n.fa-adn:before {\n  content: \"\\f170\";\n}\n\n.fa-cloudsmith:before {\n  content: \"\\f384\";\n}\n\n.fa-pied-piper-alt:before {\n  content: \"\\f1a8\";\n}\n\n.fa-square-dribbble:before {\n  content: \"\\f397\";\n}\n\n.fa-dribbble-square:before {\n  content: \"\\f397\";\n}\n\n.fa-codiepie:before {\n  content: \"\\f284\";\n}\n\n.fa-node:before {\n  content: \"\\f419\";\n}\n\n.fa-mix:before {\n  content: \"\\f3cb\";\n}\n\n.fa-steam:before {\n  content: \"\\f1b6\";\n}\n\n.fa-cc-apple-pay:before {\n  content: \"\\f416\";\n}\n\n.fa-scribd:before {\n  content: \"\\f28a\";\n}\n\n.fa-openid:before {\n  content: \"\\f19b\";\n}\n\n.fa-instalod:before {\n  content: \"\\e081\";\n}\n\n.fa-expeditedssl:before {\n  content: \"\\f23e\";\n}\n\n.fa-sellcast:before {\n  content: \"\\f2da\";\n}\n\n.fa-square-twitter:before {\n  content: \"\\f081\";\n}\n\n.fa-twitter-square:before {\n  content: \"\\f081\";\n}\n\n.fa-r-project:before {\n  content: \"\\f4f7\";\n}\n\n.fa-delicious:before {\n  content: \"\\f1a5\";\n}\n\n.fa-freebsd:before {\n  content: \"\\f3a4\";\n}\n\n.fa-vuejs:before {\n  content: \"\\f41f\";\n}\n\n.fa-accusoft:before {\n  content: \"\\f369\";\n}\n\n.fa-ioxhost:before {\n  content: \"\\f208\";\n}\n\n.fa-fonticons-fi:before {\n  content: \"\\f3a2\";\n}\n\n.fa-app-store:before {\n  content: \"\\f36f\";\n}\n\n.fa-cc-mastercard:before {\n  content: \"\\f1f1\";\n}\n\n.fa-itunes-note:before {\n  content: \"\\f3b5\";\n}\n\n.fa-golang:before {\n  content: \"\\e40f\";\n}\n\n.fa-kickstarter:before {\n  content: \"\\f3bb\";\n}\n\n.fa-grav:before {\n  content: \"\\f2d6\";\n}\n\n.fa-weibo:before {\n  content: \"\\f18a\";\n}\n\n.fa-uncharted:before {\n  content: \"\\e084\";\n}\n\n.fa-firstdraft:before {\n  content: \"\\f3a1\";\n}\n\n.fa-square-youtube:before {\n  content: \"\\f431\";\n}\n\n.fa-youtube-square:before {\n  content: \"\\f431\";\n}\n\n.fa-wikipedia-w:before {\n  content: \"\\f266\";\n}\n\n.fa-wpressr:before {\n  content: \"\\f3e4\";\n}\n\n.fa-rendact:before {\n  content: \"\\f3e4\";\n}\n\n.fa-angellist:before {\n  content: \"\\f209\";\n}\n\n.fa-galactic-republic:before {\n  content: \"\\f50c\";\n}\n\n.fa-nfc-directional:before {\n  content: \"\\e530\";\n}\n\n.fa-skype:before {\n  content: \"\\f17e\";\n}\n\n.fa-joget:before {\n  content: \"\\f3b7\";\n}\n\n.fa-fedora:before {\n  content: \"\\f798\";\n}\n\n.fa-stripe-s:before {\n  content: \"\\f42a\";\n}\n\n.fa-meta:before {\n  content: \"\\e49b\";\n}\n\n.fa-laravel:before {\n  content: \"\\f3bd\";\n}\n\n.fa-hotjar:before {\n  content: \"\\f3b1\";\n}\n\n.fa-bluetooth-b:before {\n  content: \"\\f294\";\n}\n\n.fa-sticker-mule:before {\n  content: \"\\f3f7\";\n}\n\n.fa-creative-commons-zero:before {\n  content: \"\\f4f3\";\n}\n\n.fa-hips:before {\n  content: \"\\f452\";\n}\n\n.fa-behance:before {\n  content: \"\\f1b4\";\n}\n\n.fa-reddit:before {\n  content: \"\\f1a1\";\n}\n\n.fa-discord:before {\n  content: \"\\f392\";\n}\n\n.fa-chrome:before {\n  content: \"\\f268\";\n}\n\n.fa-app-store-ios:before {\n  content: \"\\f370\";\n}\n\n.fa-cc-discover:before {\n  content: \"\\f1f2\";\n}\n\n.fa-wpbeginner:before {\n  content: \"\\f297\";\n}\n\n.fa-confluence:before {\n  content: \"\\f78d\";\n}\n\n.fa-mdb:before {\n  content: \"\\f8ca\";\n}\n\n.fa-dochub:before {\n  content: \"\\f394\";\n}\n\n.fa-accessible-icon:before {\n  content: \"\\f368\";\n}\n\n.fa-ebay:before {\n  content: \"\\f4f4\";\n}\n\n.fa-amazon:before {\n  content: \"\\f270\";\n}\n\n.fa-unsplash:before {\n  content: \"\\e07c\";\n}\n\n.fa-yarn:before {\n  content: \"\\f7e3\";\n}\n\n.fa-square-steam:before {\n  content: \"\\f1b7\";\n}\n\n.fa-steam-square:before {\n  content: \"\\f1b7\";\n}\n\n.fa-500px:before {\n  content: \"\\f26e\";\n}\n\n.fa-square-vimeo:before {\n  content: \"\\f194\";\n}\n\n.fa-vimeo-square:before {\n  content: \"\\f194\";\n}\n\n.fa-asymmetrik:before {\n  content: \"\\f372\";\n}\n\n.fa-font-awesome:before {\n  content: \"\\f2b4\";\n}\n\n.fa-font-awesome-flag:before {\n  content: \"\\f2b4\";\n}\n\n.fa-font-awesome-logo-full:before {\n  content: \"\\f2b4\";\n}\n\n.fa-gratipay:before {\n  content: \"\\f184\";\n}\n\n.fa-apple:before {\n  content: \"\\f179\";\n}\n\n.fa-hive:before {\n  content: \"\\e07f\";\n}\n\n.fa-gitkraken:before {\n  content: \"\\f3a6\";\n}\n\n.fa-keybase:before {\n  content: \"\\f4f5\";\n}\n\n.fa-apple-pay:before {\n  content: \"\\f415\";\n}\n\n.fa-padlet:before {\n  content: \"\\e4a0\";\n}\n\n.fa-amazon-pay:before {\n  content: \"\\f42c\";\n}\n\n.fa-square-github:before {\n  content: \"\\f092\";\n}\n\n.fa-github-square:before {\n  content: \"\\f092\";\n}\n\n.fa-stumbleupon:before {\n  content: \"\\f1a4\";\n}\n\n.fa-fedex:before {\n  content: \"\\f797\";\n}\n\n.fa-phoenix-framework:before {\n  content: \"\\f3dc\";\n}\n\n.fa-shopify:before {\n  content: \"\\e057\";\n}\n\n.fa-neos:before {\n  content: \"\\f612\";\n}\n\n.fa-hackerrank:before {\n  content: \"\\f5f7\";\n}\n\n.fa-researchgate:before {\n  content: \"\\f4f8\";\n}\n\n.fa-swift:before {\n  content: \"\\f8e1\";\n}\n\n.fa-angular:before {\n  content: \"\\f420\";\n}\n\n.fa-speakap:before {\n  content: \"\\f3f3\";\n}\n\n.fa-angrycreative:before {\n  content: \"\\f36e\";\n}\n\n.fa-y-combinator:before {\n  content: \"\\f23b\";\n}\n\n.fa-empire:before {\n  content: \"\\f1d1\";\n}\n\n.fa-envira:before {\n  content: \"\\f299\";\n}\n\n.fa-square-gitlab:before {\n  content: \"\\e5ae\";\n}\n\n.fa-gitlab-square:before {\n  content: \"\\e5ae\";\n}\n\n.fa-studiovinari:before {\n  content: \"\\f3f8\";\n}\n\n.fa-pied-piper:before {\n  content: \"\\f2ae\";\n}\n\n.fa-wordpress:before {\n  content: \"\\f19a\";\n}\n\n.fa-product-hunt:before {\n  content: \"\\f288\";\n}\n\n.fa-firefox:before {\n  content: \"\\f269\";\n}\n\n.fa-linode:before {\n  content: \"\\f2b8\";\n}\n\n.fa-goodreads:before {\n  content: \"\\f3a8\";\n}\n\n.fa-square-odnoklassniki:before {\n  content: \"\\f264\";\n}\n\n.fa-odnoklassniki-square:before {\n  content: \"\\f264\";\n}\n\n.fa-jsfiddle:before {\n  content: \"\\f1cc\";\n}\n\n.fa-sith:before {\n  content: \"\\f512\";\n}\n\n.fa-themeisle:before {\n  content: \"\\f2b2\";\n}\n\n.fa-page4:before {\n  content: \"\\f3d7\";\n}\n\n.fa-hashnode:before {\n  content: \"\\e499\";\n}\n\n.fa-react:before {\n  content: \"\\f41b\";\n}\n\n.fa-cc-paypal:before {\n  content: \"\\f1f4\";\n}\n\n.fa-squarespace:before {\n  content: \"\\f5be\";\n}\n\n.fa-cc-stripe:before {\n  content: \"\\f1f5\";\n}\n\n.fa-creative-commons-share:before {\n  content: \"\\f4f2\";\n}\n\n.fa-bitcoin:before {\n  content: \"\\f379\";\n}\n\n.fa-keycdn:before {\n  content: \"\\f3ba\";\n}\n\n.fa-opera:before {\n  content: \"\\f26a\";\n}\n\n.fa-itch-io:before {\n  content: \"\\f83a\";\n}\n\n.fa-umbraco:before {\n  content: \"\\f8e8\";\n}\n\n.fa-galactic-senate:before {\n  content: \"\\f50d\";\n}\n\n.fa-ubuntu:before {\n  content: \"\\f7df\";\n}\n\n.fa-draft2digital:before {\n  content: \"\\f396\";\n}\n\n.fa-stripe:before {\n  content: \"\\f429\";\n}\n\n.fa-houzz:before {\n  content: \"\\f27c\";\n}\n\n.fa-gg:before {\n  content: \"\\f260\";\n}\n\n.fa-dhl:before {\n  content: \"\\f790\";\n}\n\n.fa-square-pinterest:before {\n  content: \"\\f0d3\";\n}\n\n.fa-pinterest-square:before {\n  content: \"\\f0d3\";\n}\n\n.fa-xing:before {\n  content: \"\\f168\";\n}\n\n.fa-blackberry:before {\n  content: \"\\f37b\";\n}\n\n.fa-creative-commons-pd:before {\n  content: \"\\f4ec\";\n}\n\n.fa-playstation:before {\n  content: \"\\f3df\";\n}\n\n.fa-quinscape:before {\n  content: \"\\f459\";\n}\n\n.fa-less:before {\n  content: \"\\f41d\";\n}\n\n.fa-blogger-b:before {\n  content: \"\\f37d\";\n}\n\n.fa-opencart:before {\n  content: \"\\f23d\";\n}\n\n.fa-vine:before {\n  content: \"\\f1ca\";\n}\n\n.fa-paypal:before {\n  content: \"\\f1ed\";\n}\n\n.fa-gitlab:before {\n  content: \"\\f296\";\n}\n\n.fa-typo3:before {\n  content: \"\\f42b\";\n}\n\n.fa-reddit-alien:before {\n  content: \"\\f281\";\n}\n\n.fa-yahoo:before {\n  content: \"\\f19e\";\n}\n\n.fa-dailymotion:before {\n  content: \"\\e052\";\n}\n\n.fa-affiliatetheme:before {\n  content: \"\\f36b\";\n}\n\n.fa-pied-piper-pp:before {\n  content: \"\\f1a7\";\n}\n\n.fa-bootstrap:before {\n  content: \"\\f836\";\n}\n\n.fa-odnoklassniki:before {\n  content: \"\\f263\";\n}\n\n.fa-nfc-symbol:before {\n  content: \"\\e531\";\n}\n\n.fa-ethereum:before {\n  content: \"\\f42e\";\n}\n\n.fa-speaker-deck:before {\n  content: \"\\f83c\";\n}\n\n.fa-creative-commons-nc-eu:before {\n  content: \"\\f4e9\";\n}\n\n.fa-patreon:before {\n  content: \"\\f3d9\";\n}\n\n.fa-avianex:before {\n  content: \"\\f374\";\n}\n\n.fa-ello:before {\n  content: \"\\f5f1\";\n}\n\n.fa-gofore:before {\n  content: \"\\f3a7\";\n}\n\n.fa-bimobject:before {\n  content: \"\\f378\";\n}\n\n.fa-facebook-f:before {\n  content: \"\\f39e\";\n}\n\n.fa-square-google-plus:before {\n  content: \"\\f0d4\";\n}\n\n.fa-google-plus-square:before {\n  content: \"\\f0d4\";\n}\n\n.fa-mandalorian:before {\n  content: \"\\f50f\";\n}\n\n.fa-first-order-alt:before {\n  content: \"\\f50a\";\n}\n\n.fa-osi:before {\n  content: \"\\f41a\";\n}\n\n.fa-google-wallet:before {\n  content: \"\\f1ee\";\n}\n\n.fa-d-and-d-beyond:before {\n  content: \"\\f6ca\";\n}\n\n.fa-periscope:before {\n  content: \"\\f3da\";\n}\n\n.fa-fulcrum:before {\n  content: \"\\f50b\";\n}\n\n.fa-cloudscale:before {\n  content: \"\\f383\";\n}\n\n.fa-forumbee:before {\n  content: \"\\f211\";\n}\n\n.fa-mizuni:before {\n  content: \"\\f3cc\";\n}\n\n.fa-schlix:before {\n  content: \"\\f3ea\";\n}\n\n.fa-square-xing:before {\n  content: \"\\f169\";\n}\n\n.fa-xing-square:before {\n  content: \"\\f169\";\n}\n\n.fa-bandcamp:before {\n  content: \"\\f2d5\";\n}\n\n.fa-wpforms:before {\n  content: \"\\f298\";\n}\n\n.fa-cloudversify:before {\n  content: \"\\f385\";\n}\n\n.fa-usps:before {\n  content: \"\\f7e1\";\n}\n\n.fa-megaport:before {\n  content: \"\\f5a3\";\n}\n\n.fa-magento:before {\n  content: \"\\f3c4\";\n}\n\n.fa-spotify:before {\n  content: \"\\f1bc\";\n}\n\n.fa-optin-monster:before {\n  content: \"\\f23c\";\n}\n\n.fa-fly:before {\n  content: \"\\f417\";\n}\n\n.fa-aviato:before {\n  content: \"\\f421\";\n}\n\n.fa-itunes:before {\n  content: \"\\f3b4\";\n}\n\n.fa-cuttlefish:before {\n  content: \"\\f38c\";\n}\n\n.fa-blogger:before {\n  content: \"\\f37c\";\n}\n\n.fa-flickr:before {\n  content: \"\\f16e\";\n}\n\n.fa-viber:before {\n  content: \"\\f409\";\n}\n\n.fa-soundcloud:before {\n  content: \"\\f1be\";\n}\n\n.fa-digg:before {\n  content: \"\\f1a6\";\n}\n\n.fa-tencent-weibo:before {\n  content: \"\\f1d5\";\n}\n\n.fa-symfony:before {\n  content: \"\\f83d\";\n}\n\n.fa-maxcdn:before {\n  content: \"\\f136\";\n}\n\n.fa-etsy:before {\n  content: \"\\f2d7\";\n}\n\n.fa-facebook-messenger:before {\n  content: \"\\f39f\";\n}\n\n.fa-audible:before {\n  content: \"\\f373\";\n}\n\n.fa-think-peaks:before {\n  content: \"\\f731\";\n}\n\n.fa-bilibili:before {\n  content: \"\\e3d9\";\n}\n\n.fa-erlang:before {\n  content: \"\\f39d\";\n}\n\n.fa-cotton-bureau:before {\n  content: \"\\f89e\";\n}\n\n.fa-dashcube:before {\n  content: \"\\f210\";\n}\n\n.fa-42-group:before {\n  content: \"\\e080\";\n}\n\n.fa-innosoft:before {\n  content: \"\\e080\";\n}\n\n.fa-stack-exchange:before {\n  content: \"\\f18d\";\n}\n\n.fa-elementor:before {\n  content: \"\\f430\";\n}\n\n.fa-square-pied-piper:before {\n  content: \"\\e01e\";\n}\n\n.fa-pied-piper-square:before {\n  content: \"\\e01e\";\n}\n\n.fa-creative-commons-nd:before {\n  content: \"\\f4eb\";\n}\n\n.fa-palfed:before {\n  content: \"\\f3d8\";\n}\n\n.fa-superpowers:before {\n  content: \"\\f2dd\";\n}\n\n.fa-resolving:before {\n  content: \"\\f3e7\";\n}\n\n.fa-xbox:before {\n  content: \"\\f412\";\n}\n\n.fa-searchengin:before {\n  content: \"\\f3eb\";\n}\n\n.fa-tiktok:before {\n  content: \"\\e07b\";\n}\n\n.fa-square-facebook:before {\n  content: \"\\f082\";\n}\n\n.fa-facebook-square:before {\n  content: \"\\f082\";\n}\n\n.fa-renren:before {\n  content: \"\\f18b\";\n}\n\n.fa-linux:before {\n  content: \"\\f17c\";\n}\n\n.fa-glide:before {\n  content: \"\\f2a5\";\n}\n\n.fa-linkedin:before {\n  content: \"\\f08c\";\n}\n\n.fa-hubspot:before {\n  content: \"\\f3b2\";\n}\n\n.fa-deploydog:before {\n  content: \"\\f38e\";\n}\n\n.fa-twitch:before {\n  content: \"\\f1e8\";\n}\n\n.fa-ravelry:before {\n  content: \"\\f2d9\";\n}\n\n.fa-mixer:before {\n  content: \"\\e056\";\n}\n\n.fa-square-lastfm:before {\n  content: \"\\f203\";\n}\n\n.fa-lastfm-square:before {\n  content: \"\\f203\";\n}\n\n.fa-vimeo:before {\n  content: \"\\f40a\";\n}\n\n.fa-mendeley:before {\n  content: \"\\f7b3\";\n}\n\n.fa-uniregistry:before {\n  content: \"\\f404\";\n}\n\n.fa-figma:before {\n  content: \"\\f799\";\n}\n\n.fa-creative-commons-remix:before {\n  content: \"\\f4ee\";\n}\n\n.fa-cc-amazon-pay:before {\n  content: \"\\f42d\";\n}\n\n.fa-dropbox:before {\n  content: \"\\f16b\";\n}\n\n.fa-instagram:before {\n  content: \"\\f16d\";\n}\n\n.fa-cmplid:before {\n  content: \"\\e360\";\n}\n\n.fa-facebook:before {\n  content: \"\\f09a\";\n}\n\n.fa-gripfire:before {\n  content: \"\\f3ac\";\n}\n\n.fa-jedi-order:before {\n  content: \"\\f50e\";\n}\n\n.fa-uikit:before {\n  content: \"\\f403\";\n}\n\n.fa-fort-awesome-alt:before {\n  content: \"\\f3a3\";\n}\n\n.fa-phabricator:before {\n  content: \"\\f3db\";\n}\n\n.fa-ussunnah:before {\n  content: \"\\f407\";\n}\n\n.fa-earlybirds:before {\n  content: \"\\f39a\";\n}\n\n.fa-trade-federation:before {\n  content: \"\\f513\";\n}\n\n.fa-autoprefixer:before {\n  content: \"\\f41c\";\n}\n\n.fa-whatsapp:before {\n  content: \"\\f232\";\n}\n\n.fa-slideshare:before {\n  content: \"\\f1e7\";\n}\n\n.fa-google-play:before {\n  content: \"\\f3ab\";\n}\n\n.fa-viadeo:before {\n  content: \"\\f2a9\";\n}\n\n.fa-line:before {\n  content: \"\\f3c0\";\n}\n\n.fa-google-drive:before {\n  content: \"\\f3aa\";\n}\n\n.fa-servicestack:before {\n  content: \"\\f3ec\";\n}\n\n.fa-simplybuilt:before {\n  content: \"\\f215\";\n}\n\n.fa-bitbucket:before {\n  content: \"\\f171\";\n}\n\n.fa-imdb:before {\n  content: \"\\f2d8\";\n}\n\n.fa-deezer:before {\n  content: \"\\e077\";\n}\n\n.fa-raspberry-pi:before {\n  content: \"\\f7bb\";\n}\n\n.fa-jira:before {\n  content: \"\\f7b1\";\n}\n\n.fa-docker:before {\n  content: \"\\f395\";\n}\n\n.fa-screenpal:before {\n  content: \"\\e570\";\n}\n\n.fa-bluetooth:before {\n  content: \"\\f293\";\n}\n\n.fa-gitter:before {\n  content: \"\\f426\";\n}\n\n.fa-d-and-d:before {\n  content: \"\\f38d\";\n}\n\n.fa-microblog:before {\n  content: \"\\e01a\";\n}\n\n.fa-cc-diners-club:before {\n  content: \"\\f24c\";\n}\n\n.fa-gg-circle:before {\n  content: \"\\f261\";\n}\n\n.fa-pied-piper-hat:before {\n  content: \"\\f4e5\";\n}\n\n.fa-kickstarter-k:before {\n  content: \"\\f3bc\";\n}\n\n.fa-yandex:before {\n  content: \"\\f413\";\n}\n\n.fa-readme:before {\n  content: \"\\f4d5\";\n}\n\n.fa-html5:before {\n  content: \"\\f13b\";\n}\n\n.fa-sellsy:before {\n  content: \"\\f213\";\n}\n\n.fa-sass:before {\n  content: \"\\f41e\";\n}\n\n.fa-wirsindhandwerk:before {\n  content: \"\\e2d0\";\n}\n\n.fa-wsh:before {\n  content: \"\\e2d0\";\n}\n\n.fa-buromobelexperte:before {\n  content: \"\\f37f\";\n}\n\n.fa-salesforce:before {\n  content: \"\\f83b\";\n}\n\n.fa-octopus-deploy:before {\n  content: \"\\e082\";\n}\n\n.fa-medapps:before {\n  content: \"\\f3c6\";\n}\n\n.fa-ns8:before {\n  content: \"\\f3d5\";\n}\n\n.fa-pinterest-p:before {\n  content: \"\\f231\";\n}\n\n.fa-apper:before {\n  content: \"\\f371\";\n}\n\n.fa-fort-awesome:before {\n  content: \"\\f286\";\n}\n\n.fa-waze:before {\n  content: \"\\f83f\";\n}\n\n.fa-cc-jcb:before {\n  content: \"\\f24b\";\n}\n\n.fa-snapchat:before {\n  content: \"\\f2ab\";\n}\n\n.fa-snapchat-ghost:before {\n  content: \"\\f2ab\";\n}\n\n.fa-fantasy-flight-games:before {\n  content: \"\\f6dc\";\n}\n\n.fa-rust:before {\n  content: \"\\e07a\";\n}\n\n.fa-wix:before {\n  content: \"\\f5cf\";\n}\n\n.fa-square-behance:before {\n  content: \"\\f1b5\";\n}\n\n.fa-behance-square:before {\n  content: \"\\f1b5\";\n}\n\n.fa-supple:before {\n  content: \"\\f3f9\";\n}\n\n.fa-rebel:before {\n  content: \"\\f1d0\";\n}\n\n.fa-css3:before {\n  content: \"\\f13c\";\n}\n\n.fa-staylinked:before {\n  content: \"\\f3f5\";\n}\n\n.fa-kaggle:before {\n  content: \"\\f5fa\";\n}\n\n.fa-space-awesome:before {\n  content: \"\\e5ac\";\n}\n\n.fa-deviantart:before {\n  content: \"\\f1bd\";\n}\n\n.fa-cpanel:before {\n  content: \"\\f388\";\n}\n\n.fa-goodreads-g:before {\n  content: \"\\f3a9\";\n}\n\n.fa-square-git:before {\n  content: \"\\f1d2\";\n}\n\n.fa-git-square:before {\n  content: \"\\f1d2\";\n}\n\n.fa-square-tumblr:before {\n  content: \"\\f174\";\n}\n\n.fa-tumblr-square:before {\n  content: \"\\f174\";\n}\n\n.fa-trello:before {\n  content: \"\\f181\";\n}\n\n.fa-creative-commons-nc-jp:before {\n  content: \"\\f4ea\";\n}\n\n.fa-get-pocket:before {\n  content: \"\\f265\";\n}\n\n.fa-perbyte:before {\n  content: \"\\e083\";\n}\n\n.fa-grunt:before {\n  content: \"\\f3ad\";\n}\n\n.fa-weebly:before {\n  content: \"\\f5cc\";\n}\n\n.fa-connectdevelop:before {\n  content: \"\\f20e\";\n}\n\n.fa-leanpub:before {\n  content: \"\\f212\";\n}\n\n.fa-black-tie:before {\n  content: \"\\f27e\";\n}\n\n.fa-themeco:before {\n  content: \"\\f5c6\";\n}\n\n.fa-python:before {\n  content: \"\\f3e2\";\n}\n\n.fa-android:before {\n  content: \"\\f17b\";\n}\n\n.fa-bots:before {\n  content: \"\\e340\";\n}\n\n.fa-free-code-camp:before {\n  content: \"\\f2c5\";\n}\n\n.fa-hornbill:before {\n  content: \"\\f592\";\n}\n\n.fa-js:before {\n  content: \"\\f3b8\";\n}\n\n.fa-ideal:before {\n  content: \"\\e013\";\n}\n\n.fa-git:before {\n  content: \"\\f1d3\";\n}\n\n.fa-dev:before {\n  content: \"\\f6cc\";\n}\n\n.fa-sketch:before {\n  content: \"\\f7c6\";\n}\n\n.fa-yandex-international:before {\n  content: \"\\f414\";\n}\n\n.fa-cc-amex:before {\n  content: \"\\f1f3\";\n}\n\n.fa-uber:before {\n  content: \"\\f402\";\n}\n\n.fa-github:before {\n  content: \"\\f09b\";\n}\n\n.fa-php:before {\n  content: \"\\f457\";\n}\n\n.fa-alipay:before {\n  content: \"\\f642\";\n}\n\n.fa-youtube:before {\n  content: \"\\f167\";\n}\n\n.fa-skyatlas:before {\n  content: \"\\f216\";\n}\n\n.fa-firefox-browser:before {\n  content: \"\\e007\";\n}\n\n.fa-replyd:before {\n  content: \"\\f3e6\";\n}\n\n.fa-suse:before {\n  content: \"\\f7d6\";\n}\n\n.fa-jenkins:before {\n  content: \"\\f3b6\";\n}\n\n.fa-twitter:before {\n  content: \"\\f099\";\n}\n\n.fa-rockrms:before {\n  content: \"\\f3e9\";\n}\n\n.fa-pinterest:before {\n  content: \"\\f0d2\";\n}\n\n.fa-buffer:before {\n  content: \"\\f837\";\n}\n\n.fa-npm:before {\n  content: \"\\f3d4\";\n}\n\n.fa-yammer:before {\n  content: \"\\f840\";\n}\n\n.fa-btc:before {\n  content: \"\\f15a\";\n}\n\n.fa-dribbble:before {\n  content: \"\\f17d\";\n}\n\n.fa-stumbleupon-circle:before {\n  content: \"\\f1a3\";\n}\n\n.fa-internet-explorer:before {\n  content: \"\\f26b\";\n}\n\n.fa-telegram:before {\n  content: \"\\f2c6\";\n}\n\n.fa-telegram-plane:before {\n  content: \"\\f2c6\";\n}\n\n.fa-old-republic:before {\n  content: \"\\f510\";\n}\n\n.fa-square-whatsapp:before {\n  content: \"\\f40c\";\n}\n\n.fa-whatsapp-square:before {\n  content: \"\\f40c\";\n}\n\n.fa-node-js:before {\n  content: \"\\f3d3\";\n}\n\n.fa-edge-legacy:before {\n  content: \"\\e078\";\n}\n\n.fa-slack:before {\n  content: \"\\f198\";\n}\n\n.fa-slack-hash:before {\n  content: \"\\f198\";\n}\n\n.fa-medrt:before {\n  content: \"\\f3c8\";\n}\n\n.fa-usb:before {\n  content: \"\\f287\";\n}\n\n.fa-tumblr:before {\n  content: \"\\f173\";\n}\n\n.fa-vaadin:before {\n  content: \"\\f408\";\n}\n\n.fa-quora:before {\n  content: \"\\f2c4\";\n}\n\n.fa-reacteurope:before {\n  content: \"\\f75d\";\n}\n\n.fa-medium:before {\n  content: \"\\f23a\";\n}\n\n.fa-medium-m:before {\n  content: \"\\f23a\";\n}\n\n.fa-amilia:before {\n  content: \"\\f36d\";\n}\n\n.fa-mixcloud:before {\n  content: \"\\f289\";\n}\n\n.fa-flipboard:before {\n  content: \"\\f44d\";\n}\n\n.fa-viacoin:before {\n  content: \"\\f237\";\n}\n\n.fa-critical-role:before {\n  content: \"\\f6c9\";\n}\n\n.fa-sitrox:before {\n  content: \"\\e44a\";\n}\n\n.fa-discourse:before {\n  content: \"\\f393\";\n}\n\n.fa-joomla:before {\n  content: \"\\f1aa\";\n}\n\n.fa-mastodon:before {\n  content: \"\\f4f6\";\n}\n\n.fa-airbnb:before {\n  content: \"\\f834\";\n}\n\n.fa-wolf-pack-battalion:before {\n  content: \"\\f514\";\n}\n\n.fa-buy-n-large:before {\n  content: \"\\f8a6\";\n}\n\n.fa-gulp:before {\n  content: \"\\f3ae\";\n}\n\n.fa-creative-commons-sampling-plus:before {\n  content: \"\\f4f1\";\n}\n\n.fa-strava:before {\n  content: \"\\f428\";\n}\n\n.fa-ember:before {\n  content: \"\\f423\";\n}\n\n.fa-canadian-maple-leaf:before {\n  content: \"\\f785\";\n}\n\n.fa-teamspeak:before {\n  content: \"\\f4f9\";\n}\n\n.fa-pushed:before {\n  content: \"\\f3e1\";\n}\n\n.fa-wordpress-simple:before {\n  content: \"\\f411\";\n}\n\n.fa-nutritionix:before {\n  content: \"\\f3d6\";\n}\n\n.fa-wodu:before {\n  content: \"\\e088\";\n}\n\n.fa-google-pay:before {\n  content: \"\\e079\";\n}\n\n.fa-intercom:before {\n  content: \"\\f7af\";\n}\n\n.fa-zhihu:before {\n  content: \"\\f63f\";\n}\n\n.fa-korvue:before {\n  content: \"\\f42f\";\n}\n\n.fa-pix:before {\n  content: \"\\e43a\";\n}\n\n.fa-steam-symbol:before {\n  content: \"\\f3f6\";\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/*!\n * Font Awesome Free 6.2.0 by @fontawesome - https://fontawesome.com\n * License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)\n * Copyright 2022 Fonticons, Inc.\n */\n.fa {\n  font-family: var(--fa-style-family, \"Font Awesome 6 Free\");\n  font-weight: var(--fa-style, 900);\n}\n\n.fa,\n.fa-classic,\n.fa-sharp,\n.fas,\n.fa-solid,\n.far,\n.fa-regular,\n.fab,\n.fa-brands {\n  -moz-osx-font-smoothing: grayscale;\n  -webkit-font-smoothing: antialiased;\n  display: var(--fa-display, inline-block);\n  font-style: normal;\n  font-variant: normal;\n  line-height: 1;\n  text-rendering: auto;\n}\n\n.fas,\n.fa-classic,\n.fa-solid,\n.far,\n.fa-regular {\n  font-family: \"Font Awesome 6 Free\";\n}\n\n.fab,\n.fa-brands {\n  font-family: \"Font Awesome 6 Brands\";\n}\n\n.fa-1x {\n  font-size: 1em;\n}\n\n.fa-2x {\n  font-size: 2em;\n}\n\n.fa-3x {\n  font-size: 3em;\n}\n\n.fa-4x {\n  font-size: 4em;\n}\n\n.fa-5x {\n  font-size: 5em;\n}\n\n.fa-6x {\n  font-size: 6em;\n}\n\n.fa-7x {\n  font-size: 7em;\n}\n\n.fa-8x {\n  font-size: 8em;\n}\n\n.fa-9x {\n  font-size: 9em;\n}\n\n.fa-10x {\n  font-size: 10em;\n}\n\n.fa-2xs {\n  font-size: 0.625em;\n  line-height: 0.1em;\n  vertical-align: 0.225em;\n}\n\n.fa-xs {\n  font-size: 0.75em;\n  line-height: 0.0833333337em;\n  vertical-align: 0.125em;\n}\n\n.fa-sm {\n  font-size: 0.875em;\n  line-height: 0.0714285718em;\n  vertical-align: 0.0535714295em;\n}\n\n.fa-lg {\n  font-size: 1.25em;\n  line-height: 0.05em;\n  vertical-align: -0.075em;\n}\n\n.fa-xl {\n  font-size: 1.5em;\n  line-height: 0.0416666682em;\n  vertical-align: -0.125em;\n}\n\n.fa-2xl {\n  font-size: 2em;\n  line-height: 0.03125em;\n  vertical-align: -0.1875em;\n}\n\n.fa-fw {\n  text-align: center;\n  width: 1.25em;\n}\n\n.fa-ul {\n  list-style-type: none;\n  margin-left: var(--fa-li-margin, 2.5em);\n  padding-left: 0;\n}\n.fa-ul > li {\n  position: relative;\n}\n\n.fa-li {\n  left: calc(var(--fa-li-width, 2em) * -1);\n  position: absolute;\n  text-align: center;\n  width: var(--fa-li-width, 2em);\n  line-height: inherit;\n}\n\n.fa-border {\n  border-color: var(--fa-border-color, #eee);\n  border-radius: var(--fa-border-radius, 0.1em);\n  border-style: var(--fa-border-style, solid);\n  border-width: var(--fa-border-width, 0.08em);\n  padding: var(--fa-border-padding, 0.2em 0.25em 0.15em);\n}\n\n.fa-pull-left {\n  float: left;\n  margin-right: var(--fa-pull-margin, 0.3em);\n}\n\n.fa-pull-right {\n  float: right;\n  margin-left: var(--fa-pull-margin, 0.3em);\n}\n\n.fa-beat {\n  animation-name: fa-beat;\n  animation-delay: var(--fa-animation-delay, 0s);\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 1s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, ease-in-out);\n}\n\n.fa-bounce {\n  animation-name: fa-bounce;\n  animation-delay: var(--fa-animation-delay, 0s);\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 1s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.28, 0.84, 0.42, 1));\n}\n\n.fa-fade {\n  animation-name: fa-fade;\n  animation-delay: var(--fa-animation-delay, 0s);\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 1s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));\n}\n\n.fa-beat-fade {\n  animation-name: fa-beat-fade;\n  animation-delay: var(--fa-animation-delay, 0s);\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 1s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));\n}\n\n.fa-flip {\n  animation-name: fa-flip;\n  animation-delay: var(--fa-animation-delay, 0s);\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 1s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, ease-in-out);\n}\n\n.fa-shake {\n  animation-name: fa-shake;\n  animation-delay: var(--fa-animation-delay, 0s);\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 1s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, linear);\n}\n\n.fa-spin {\n  animation-name: fa-spin;\n  animation-delay: var(--fa-animation-delay, 0s);\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 2s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, linear);\n}\n\n.fa-spin-reverse {\n  --fa-animation-direction: reverse;\n}\n\n.fa-pulse,\n.fa-spin-pulse {\n  animation-name: fa-spin;\n  animation-direction: var(--fa-animation-direction, normal);\n  animation-duration: var(--fa-animation-duration, 1s);\n  animation-iteration-count: var(--fa-animation-iteration-count, infinite);\n  animation-timing-function: var(--fa-animation-timing, steps(8));\n}\n\n@media (prefers-reduced-motion: reduce) {\n  .fa-beat,\n  .fa-bounce,\n  .fa-fade,\n  .fa-beat-fade,\n  .fa-flip,\n  .fa-pulse,\n  .fa-shake,\n  .fa-spin,\n  .fa-spin-pulse {\n    animation-delay: -1ms;\n    animation-duration: 1ms;\n    animation-iteration-count: 1;\n    transition-delay: 0s;\n    transition-duration: 0s;\n  }\n}\n@keyframes fa-beat {\n  0%, 90% {\n    transform: scale(1);\n  }\n  45% {\n    transform: scale(var(--fa-beat-scale, 1.25));\n  }\n}\n@keyframes fa-bounce {\n  0% {\n    transform: scale(1, 1) translateY(0);\n  }\n  10% {\n    transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);\n  }\n  30% {\n    transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));\n  }\n  50% {\n    transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);\n  }\n  57% {\n    transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));\n  }\n  64% {\n    transform: scale(1, 1) translateY(0);\n  }\n  100% {\n    transform: scale(1, 1) translateY(0);\n  }\n}\n@keyframes fa-fade {\n  50% {\n    opacity: var(--fa-fade-opacity, 0.4);\n  }\n}\n@keyframes fa-beat-fade {\n  0%, 100% {\n    opacity: var(--fa-beat-fade-opacity, 0.4);\n    transform: scale(1);\n  }\n  50% {\n    opacity: 1;\n    transform: scale(var(--fa-beat-fade-scale, 1.125));\n  }\n}\n@keyframes fa-flip {\n  50% {\n    transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));\n  }\n}\n@keyframes fa-shake {\n  0% {\n    transform: rotate(-15deg);\n  }\n  4% {\n    transform: rotate(15deg);\n  }\n  8%, 24% {\n    transform: rotate(-18deg);\n  }\n  12%, 28% {\n    transform: rotate(18deg);\n  }\n  16% {\n    transform: rotate(-22deg);\n  }\n  20% {\n    transform: rotate(22deg);\n  }\n  32% {\n    transform: rotate(-12deg);\n  }\n  36% {\n    transform: rotate(12deg);\n  }\n  40%, 100% {\n    transform: rotate(0deg);\n  }\n}\n@keyframes fa-spin {\n  0% {\n    transform: rotate(0deg);\n  }\n  100% {\n    transform: rotate(360deg);\n  }\n}\n.fa-rotate-90 {\n  transform: rotate(90deg);\n}\n\n.fa-rotate-180 {\n  transform: rotate(180deg);\n}\n\n.fa-rotate-270 {\n  transform: rotate(270deg);\n}\n\n.fa-flip-horizontal {\n  transform: scale(-1, 1);\n}\n\n.fa-flip-vertical {\n  transform: scale(1, -1);\n}\n\n.fa-flip-both,\n.fa-flip-horizontal.fa-flip-vertical {\n  transform: scale(-1, -1);\n}\n\n.fa-rotate-by {\n  transform: rotate(var(--fa-rotate-angle, none));\n}\n\n.fa-stack {\n  display: inline-block;\n  height: 2em;\n  line-height: 2em;\n  position: relative;\n  vertical-align: middle;\n  width: 2.5em;\n}\n\n.fa-stack-1x,\n.fa-stack-2x {\n  left: 0;\n  position: absolute;\n  text-align: center;\n  width: 100%;\n  z-index: var(--fa-stack-z-index, auto);\n}\n\n.fa-stack-1x {\n  line-height: inherit;\n}\n\n.fa-stack-2x {\n  font-size: 2em;\n}\n\n.fa-inverse {\n  color: var(--fa-inverse, #fff);\n}\n\n/* Font Awesome uses the Unicode Private Use Area (PUA) to ensure screen\nreaders do not read off random characters that represent icons */\n.fa-0::before {\n  content: \"\\30 \";\n}\n\n.fa-1::before {\n  content: \"\\31 \";\n}\n\n.fa-2::before {\n  content: \"\\32 \";\n}\n\n.fa-3::before {\n  content: \"\\33 \";\n}\n\n.fa-4::before {\n  content: \"\\34 \";\n}\n\n.fa-5::before {\n  content: \"\\35 \";\n}\n\n.fa-6::before {\n  content: \"\\36 \";\n}\n\n.fa-7::before {\n  content: \"\\37 \";\n}\n\n.fa-8::before {\n  content: \"\\38 \";\n}\n\n.fa-9::before {\n  content: \"\\39 \";\n}\n\n.fa-fill-drip::before {\n  content: \"\\f576\";\n}\n\n.fa-arrows-to-circle::before {\n  content: \"\\e4bd\";\n}\n\n.fa-circle-chevron-right::before {\n  content: \"\\f138\";\n}\n\n.fa-chevron-circle-right::before {\n  content: \"\\f138\";\n}\n\n.fa-at::before {\n  content: \"\\@\";\n}\n\n.fa-trash-can::before {\n  content: \"\\f2ed\";\n}\n\n.fa-trash-alt::before {\n  content: \"\\f2ed\";\n}\n\n.fa-text-height::before {\n  content: \"\\f034\";\n}\n\n.fa-user-xmark::before {\n  content: \"\\f235\";\n}\n\n.fa-user-times::before {\n  content: \"\\f235\";\n}\n\n.fa-stethoscope::before {\n  content: \"\\f0f1\";\n}\n\n.fa-message::before {\n  content: \"\\f27a\";\n}\n\n.fa-comment-alt::before {\n  content: \"\\f27a\";\n}\n\n.fa-info::before {\n  content: \"\\f129\";\n}\n\n.fa-down-left-and-up-right-to-center::before {\n  content: \"\\f422\";\n}\n\n.fa-compress-alt::before {\n  content: \"\\f422\";\n}\n\n.fa-explosion::before {\n  content: \"\\e4e9\";\n}\n\n.fa-file-lines::before {\n  content: \"\\f15c\";\n}\n\n.fa-file-alt::before {\n  content: \"\\f15c\";\n}\n\n.fa-file-text::before {\n  content: \"\\f15c\";\n}\n\n.fa-wave-square::before {\n  content: \"\\f83e\";\n}\n\n.fa-ring::before {\n  content: \"\\f70b\";\n}\n\n.fa-building-un::before {\n  content: \"\\e4d9\";\n}\n\n.fa-dice-three::before {\n  content: \"\\f527\";\n}\n\n.fa-calendar-days::before {\n  content: \"\\f073\";\n}\n\n.fa-calendar-alt::before {\n  content: \"\\f073\";\n}\n\n.fa-anchor-circle-check::before {\n  content: \"\\e4aa\";\n}\n\n.fa-building-circle-arrow-right::before {\n  content: \"\\e4d1\";\n}\n\n.fa-volleyball::before {\n  content: \"\\f45f\";\n}\n\n.fa-volleyball-ball::before {\n  content: \"\\f45f\";\n}\n\n.fa-arrows-up-to-line::before {\n  content: \"\\e4c2\";\n}\n\n.fa-sort-down::before {\n  content: \"\\f0dd\";\n}\n\n.fa-sort-desc::before {\n  content: \"\\f0dd\";\n}\n\n.fa-circle-minus::before {\n  content: \"\\f056\";\n}\n\n.fa-minus-circle::before {\n  content: \"\\f056\";\n}\n\n.fa-door-open::before {\n  content: \"\\f52b\";\n}\n\n.fa-right-from-bracket::before {\n  content: \"\\f2f5\";\n}\n\n.fa-sign-out-alt::before {\n  content: \"\\f2f5\";\n}\n\n.fa-atom::before {\n  content: \"\\f5d2\";\n}\n\n.fa-soap::before {\n  content: \"\\e06e\";\n}\n\n.fa-icons::before {\n  content: \"\\f86d\";\n}\n\n.fa-heart-music-camera-bolt::before {\n  content: \"\\f86d\";\n}\n\n.fa-microphone-lines-slash::before {\n  content: \"\\f539\";\n}\n\n.fa-microphone-alt-slash::before {\n  content: \"\\f539\";\n}\n\n.fa-bridge-circle-check::before {\n  content: \"\\e4c9\";\n}\n\n.fa-pump-medical::before {\n  content: \"\\e06a\";\n}\n\n.fa-fingerprint::before {\n  content: \"\\f577\";\n}\n\n.fa-hand-point-right::before {\n  content: \"\\f0a4\";\n}\n\n.fa-magnifying-glass-location::before {\n  content: \"\\f689\";\n}\n\n.fa-search-location::before {\n  content: \"\\f689\";\n}\n\n.fa-forward-step::before {\n  content: \"\\f051\";\n}\n\n.fa-step-forward::before {\n  content: \"\\f051\";\n}\n\n.fa-face-smile-beam::before {\n  content: \"\\f5b8\";\n}\n\n.fa-smile-beam::before {\n  content: \"\\f5b8\";\n}\n\n.fa-flag-checkered::before {\n  content: \"\\f11e\";\n}\n\n.fa-football::before {\n  content: \"\\f44e\";\n}\n\n.fa-football-ball::before {\n  content: \"\\f44e\";\n}\n\n.fa-school-circle-exclamation::before {\n  content: \"\\e56c\";\n}\n\n.fa-crop::before {\n  content: \"\\f125\";\n}\n\n.fa-angles-down::before {\n  content: \"\\f103\";\n}\n\n.fa-angle-double-down::before {\n  content: \"\\f103\";\n}\n\n.fa-users-rectangle::before {\n  content: \"\\e594\";\n}\n\n.fa-people-roof::before {\n  content: \"\\e537\";\n}\n\n.fa-people-line::before {\n  content: \"\\e534\";\n}\n\n.fa-beer-mug-empty::before {\n  content: \"\\f0fc\";\n}\n\n.fa-beer::before {\n  content: \"\\f0fc\";\n}\n\n.fa-diagram-predecessor::before {\n  content: \"\\e477\";\n}\n\n.fa-arrow-up-long::before {\n  content: \"\\f176\";\n}\n\n.fa-long-arrow-up::before {\n  content: \"\\f176\";\n}\n\n.fa-fire-flame-simple::before {\n  content: \"\\f46a\";\n}\n\n.fa-burn::before {\n  content: \"\\f46a\";\n}\n\n.fa-person::before {\n  content: \"\\f183\";\n}\n\n.fa-male::before {\n  content: \"\\f183\";\n}\n\n.fa-laptop::before {\n  content: \"\\f109\";\n}\n\n.fa-file-csv::before {\n  content: \"\\f6dd\";\n}\n\n.fa-menorah::before {\n  content: \"\\f676\";\n}\n\n.fa-truck-plane::before {\n  content: \"\\e58f\";\n}\n\n.fa-record-vinyl::before {\n  content: \"\\f8d9\";\n}\n\n.fa-face-grin-stars::before {\n  content: \"\\f587\";\n}\n\n.fa-grin-stars::before {\n  content: \"\\f587\";\n}\n\n.fa-bong::before {\n  content: \"\\f55c\";\n}\n\n.fa-spaghetti-monster-flying::before {\n  content: \"\\f67b\";\n}\n\n.fa-pastafarianism::before {\n  content: \"\\f67b\";\n}\n\n.fa-arrow-down-up-across-line::before {\n  content: \"\\e4af\";\n}\n\n.fa-spoon::before {\n  content: \"\\f2e5\";\n}\n\n.fa-utensil-spoon::before {\n  content: \"\\f2e5\";\n}\n\n.fa-jar-wheat::before {\n  content: \"\\e517\";\n}\n\n.fa-envelopes-bulk::before {\n  content: \"\\f674\";\n}\n\n.fa-mail-bulk::before {\n  content: \"\\f674\";\n}\n\n.fa-file-circle-exclamation::before {\n  content: \"\\e4eb\";\n}\n\n.fa-circle-h::before {\n  content: \"\\f47e\";\n}\n\n.fa-hospital-symbol::before {\n  content: \"\\f47e\";\n}\n\n.fa-pager::before {\n  content: \"\\f815\";\n}\n\n.fa-address-book::before {\n  content: \"\\f2b9\";\n}\n\n.fa-contact-book::before {\n  content: \"\\f2b9\";\n}\n\n.fa-strikethrough::before {\n  content: \"\\f0cc\";\n}\n\n.fa-k::before {\n  content: \"K\";\n}\n\n.fa-landmark-flag::before {\n  content: \"\\e51c\";\n}\n\n.fa-pencil::before {\n  content: \"\\f303\";\n}\n\n.fa-pencil-alt::before {\n  content: \"\\f303\";\n}\n\n.fa-backward::before {\n  content: \"\\f04a\";\n}\n\n.fa-caret-right::before {\n  content: \"\\f0da\";\n}\n\n.fa-comments::before {\n  content: \"\\f086\";\n}\n\n.fa-paste::before {\n  content: \"\\f0ea\";\n}\n\n.fa-file-clipboard::before {\n  content: \"\\f0ea\";\n}\n\n.fa-code-pull-request::before {\n  content: \"\\e13c\";\n}\n\n.fa-clipboard-list::before {\n  content: \"\\f46d\";\n}\n\n.fa-truck-ramp-box::before {\n  content: \"\\f4de\";\n}\n\n.fa-truck-loading::before {\n  content: \"\\f4de\";\n}\n\n.fa-user-check::before {\n  content: \"\\f4fc\";\n}\n\n.fa-vial-virus::before {\n  content: \"\\e597\";\n}\n\n.fa-sheet-plastic::before {\n  content: \"\\e571\";\n}\n\n.fa-blog::before {\n  content: \"\\f781\";\n}\n\n.fa-user-ninja::before {\n  content: \"\\f504\";\n}\n\n.fa-person-arrow-up-from-line::before {\n  content: \"\\e539\";\n}\n\n.fa-scroll-torah::before {\n  content: \"\\f6a0\";\n}\n\n.fa-torah::before {\n  content: \"\\f6a0\";\n}\n\n.fa-broom-ball::before {\n  content: \"\\f458\";\n}\n\n.fa-quidditch::before {\n  content: \"\\f458\";\n}\n\n.fa-quidditch-broom-ball::before {\n  content: \"\\f458\";\n}\n\n.fa-toggle-off::before {\n  content: \"\\f204\";\n}\n\n.fa-box-archive::before {\n  content: \"\\f187\";\n}\n\n.fa-archive::before {\n  content: \"\\f187\";\n}\n\n.fa-person-drowning::before {\n  content: \"\\e545\";\n}\n\n.fa-arrow-down-9-1::before {\n  content: \"\\f886\";\n}\n\n.fa-sort-numeric-desc::before {\n  content: \"\\f886\";\n}\n\n.fa-sort-numeric-down-alt::before {\n  content: \"\\f886\";\n}\n\n.fa-face-grin-tongue-squint::before {\n  content: \"\\f58a\";\n}\n\n.fa-grin-tongue-squint::before {\n  content: \"\\f58a\";\n}\n\n.fa-spray-can::before {\n  content: \"\\f5bd\";\n}\n\n.fa-truck-monster::before {\n  content: \"\\f63b\";\n}\n\n.fa-w::before {\n  content: \"W\";\n}\n\n.fa-earth-africa::before {\n  content: \"\\f57c\";\n}\n\n.fa-globe-africa::before {\n  content: \"\\f57c\";\n}\n\n.fa-rainbow::before {\n  content: \"\\f75b\";\n}\n\n.fa-circle-notch::before {\n  content: \"\\f1ce\";\n}\n\n.fa-tablet-screen-button::before {\n  content: \"\\f3fa\";\n}\n\n.fa-tablet-alt::before {\n  content: \"\\f3fa\";\n}\n\n.fa-paw::before {\n  content: \"\\f1b0\";\n}\n\n.fa-cloud::before {\n  content: \"\\f0c2\";\n}\n\n.fa-trowel-bricks::before {\n  content: \"\\e58a\";\n}\n\n.fa-face-flushed::before {\n  content: \"\\f579\";\n}\n\n.fa-flushed::before {\n  content: \"\\f579\";\n}\n\n.fa-hospital-user::before {\n  content: \"\\f80d\";\n}\n\n.fa-tent-arrow-left-right::before {\n  content: \"\\e57f\";\n}\n\n.fa-gavel::before {\n  content: \"\\f0e3\";\n}\n\n.fa-legal::before {\n  content: \"\\f0e3\";\n}\n\n.fa-binoculars::before {\n  content: \"\\f1e5\";\n}\n\n.fa-microphone-slash::before {\n  content: \"\\f131\";\n}\n\n.fa-box-tissue::before {\n  content: \"\\e05b\";\n}\n\n.fa-motorcycle::before {\n  content: \"\\f21c\";\n}\n\n.fa-bell-concierge::before {\n  content: \"\\f562\";\n}\n\n.fa-concierge-bell::before {\n  content: \"\\f562\";\n}\n\n.fa-pen-ruler::before {\n  content: \"\\f5ae\";\n}\n\n.fa-pencil-ruler::before {\n  content: \"\\f5ae\";\n}\n\n.fa-people-arrows::before {\n  content: \"\\e068\";\n}\n\n.fa-people-arrows-left-right::before {\n  content: \"\\e068\";\n}\n\n.fa-mars-and-venus-burst::before {\n  content: \"\\e523\";\n}\n\n.fa-square-caret-right::before {\n  content: \"\\f152\";\n}\n\n.fa-caret-square-right::before {\n  content: \"\\f152\";\n}\n\n.fa-scissors::before {\n  content: \"\\f0c4\";\n}\n\n.fa-cut::before {\n  content: \"\\f0c4\";\n}\n\n.fa-sun-plant-wilt::before {\n  content: \"\\e57a\";\n}\n\n.fa-toilets-portable::before {\n  content: \"\\e584\";\n}\n\n.fa-hockey-puck::before {\n  content: \"\\f453\";\n}\n\n.fa-table::before {\n  content: \"\\f0ce\";\n}\n\n.fa-magnifying-glass-arrow-right::before {\n  content: \"\\e521\";\n}\n\n.fa-tachograph-digital::before {\n  content: \"\\f566\";\n}\n\n.fa-digital-tachograph::before {\n  content: \"\\f566\";\n}\n\n.fa-users-slash::before {\n  content: \"\\e073\";\n}\n\n.fa-clover::before {\n  content: \"\\e139\";\n}\n\n.fa-reply::before {\n  content: \"\\f3e5\";\n}\n\n.fa-mail-reply::before {\n  content: \"\\f3e5\";\n}\n\n.fa-star-and-crescent::before {\n  content: \"\\f699\";\n}\n\n.fa-house-fire::before {\n  content: \"\\e50c\";\n}\n\n.fa-square-minus::before {\n  content: \"\\f146\";\n}\n\n.fa-minus-square::before {\n  content: \"\\f146\";\n}\n\n.fa-helicopter::before {\n  content: \"\\f533\";\n}\n\n.fa-compass::before {\n  content: \"\\f14e\";\n}\n\n.fa-square-caret-down::before {\n  content: \"\\f150\";\n}\n\n.fa-caret-square-down::before {\n  content: \"\\f150\";\n}\n\n.fa-file-circle-question::before {\n  content: \"\\e4ef\";\n}\n\n.fa-laptop-code::before {\n  content: \"\\f5fc\";\n}\n\n.fa-swatchbook::before {\n  content: \"\\f5c3\";\n}\n\n.fa-prescription-bottle::before {\n  content: \"\\f485\";\n}\n\n.fa-bars::before {\n  content: \"\\f0c9\";\n}\n\n.fa-navicon::before {\n  content: \"\\f0c9\";\n}\n\n.fa-people-group::before {\n  content: \"\\e533\";\n}\n\n.fa-hourglass-end::before {\n  content: \"\\f253\";\n}\n\n.fa-hourglass-3::before {\n  content: \"\\f253\";\n}\n\n.fa-heart-crack::before {\n  content: \"\\f7a9\";\n}\n\n.fa-heart-broken::before {\n  content: \"\\f7a9\";\n}\n\n.fa-square-up-right::before {\n  content: \"\\f360\";\n}\n\n.fa-external-link-square-alt::before {\n  content: \"\\f360\";\n}\n\n.fa-face-kiss-beam::before {\n  content: \"\\f597\";\n}\n\n.fa-kiss-beam::before {\n  content: \"\\f597\";\n}\n\n.fa-film::before {\n  content: \"\\f008\";\n}\n\n.fa-ruler-horizontal::before {\n  content: \"\\f547\";\n}\n\n.fa-people-robbery::before {\n  content: \"\\e536\";\n}\n\n.fa-lightbulb::before {\n  content: \"\\f0eb\";\n}\n\n.fa-caret-left::before {\n  content: \"\\f0d9\";\n}\n\n.fa-circle-exclamation::before {\n  content: \"\\f06a\";\n}\n\n.fa-exclamation-circle::before {\n  content: \"\\f06a\";\n}\n\n.fa-school-circle-xmark::before {\n  content: \"\\e56d\";\n}\n\n.fa-arrow-right-from-bracket::before {\n  content: \"\\f08b\";\n}\n\n.fa-sign-out::before {\n  content: \"\\f08b\";\n}\n\n.fa-circle-chevron-down::before {\n  content: \"\\f13a\";\n}\n\n.fa-chevron-circle-down::before {\n  content: \"\\f13a\";\n}\n\n.fa-unlock-keyhole::before {\n  content: \"\\f13e\";\n}\n\n.fa-unlock-alt::before {\n  content: \"\\f13e\";\n}\n\n.fa-cloud-showers-heavy::before {\n  content: \"\\f740\";\n}\n\n.fa-headphones-simple::before {\n  content: \"\\f58f\";\n}\n\n.fa-headphones-alt::before {\n  content: \"\\f58f\";\n}\n\n.fa-sitemap::before {\n  content: \"\\f0e8\";\n}\n\n.fa-circle-dollar-to-slot::before {\n  content: \"\\f4b9\";\n}\n\n.fa-donate::before {\n  content: \"\\f4b9\";\n}\n\n.fa-memory::before {\n  content: \"\\f538\";\n}\n\n.fa-road-spikes::before {\n  content: \"\\e568\";\n}\n\n.fa-fire-burner::before {\n  content: \"\\e4f1\";\n}\n\n.fa-flag::before {\n  content: \"\\f024\";\n}\n\n.fa-hanukiah::before {\n  content: \"\\f6e6\";\n}\n\n.fa-feather::before {\n  content: \"\\f52d\";\n}\n\n.fa-volume-low::before {\n  content: \"\\f027\";\n}\n\n.fa-volume-down::before {\n  content: \"\\f027\";\n}\n\n.fa-comment-slash::before {\n  content: \"\\f4b3\";\n}\n\n.fa-cloud-sun-rain::before {\n  content: \"\\f743\";\n}\n\n.fa-compress::before {\n  content: \"\\f066\";\n}\n\n.fa-wheat-awn::before {\n  content: \"\\e2cd\";\n}\n\n.fa-wheat-alt::before {\n  content: \"\\e2cd\";\n}\n\n.fa-ankh::before {\n  content: \"\\f644\";\n}\n\n.fa-hands-holding-child::before {\n  content: \"\\e4fa\";\n}\n\n.fa-asterisk::before {\n  content: \"\\*\";\n}\n\n.fa-square-check::before {\n  content: \"\\f14a\";\n}\n\n.fa-check-square::before {\n  content: \"\\f14a\";\n}\n\n.fa-peseta-sign::before {\n  content: \"\\e221\";\n}\n\n.fa-heading::before {\n  content: \"\\f1dc\";\n}\n\n.fa-header::before {\n  content: \"\\f1dc\";\n}\n\n.fa-ghost::before {\n  content: \"\\f6e2\";\n}\n\n.fa-list::before {\n  content: \"\\f03a\";\n}\n\n.fa-list-squares::before {\n  content: \"\\f03a\";\n}\n\n.fa-square-phone-flip::before {\n  content: \"\\f87b\";\n}\n\n.fa-phone-square-alt::before {\n  content: \"\\f87b\";\n}\n\n.fa-cart-plus::before {\n  content: \"\\f217\";\n}\n\n.fa-gamepad::before {\n  content: \"\\f11b\";\n}\n\n.fa-circle-dot::before {\n  content: \"\\f192\";\n}\n\n.fa-dot-circle::before {\n  content: \"\\f192\";\n}\n\n.fa-face-dizzy::before {\n  content: \"\\f567\";\n}\n\n.fa-dizzy::before {\n  content: \"\\f567\";\n}\n\n.fa-egg::before {\n  content: \"\\f7fb\";\n}\n\n.fa-house-medical-circle-xmark::before {\n  content: \"\\e513\";\n}\n\n.fa-campground::before {\n  content: \"\\f6bb\";\n}\n\n.fa-folder-plus::before {\n  content: \"\\f65e\";\n}\n\n.fa-futbol::before {\n  content: \"\\f1e3\";\n}\n\n.fa-futbol-ball::before {\n  content: \"\\f1e3\";\n}\n\n.fa-soccer-ball::before {\n  content: \"\\f1e3\";\n}\n\n.fa-paintbrush::before {\n  content: \"\\f1fc\";\n}\n\n.fa-paint-brush::before {\n  content: \"\\f1fc\";\n}\n\n.fa-lock::before {\n  content: \"\\f023\";\n}\n\n.fa-gas-pump::before {\n  content: \"\\f52f\";\n}\n\n.fa-hot-tub-person::before {\n  content: \"\\f593\";\n}\n\n.fa-hot-tub::before {\n  content: \"\\f593\";\n}\n\n.fa-map-location::before {\n  content: \"\\f59f\";\n}\n\n.fa-map-marked::before {\n  content: \"\\f59f\";\n}\n\n.fa-house-flood-water::before {\n  content: \"\\e50e\";\n}\n\n.fa-tree::before {\n  content: \"\\f1bb\";\n}\n\n.fa-bridge-lock::before {\n  content: \"\\e4cc\";\n}\n\n.fa-sack-dollar::before {\n  content: \"\\f81d\";\n}\n\n.fa-pen-to-square::before {\n  content: \"\\f044\";\n}\n\n.fa-edit::before {\n  content: \"\\f044\";\n}\n\n.fa-car-side::before {\n  content: \"\\f5e4\";\n}\n\n.fa-share-nodes::before {\n  content: \"\\f1e0\";\n}\n\n.fa-share-alt::before {\n  content: \"\\f1e0\";\n}\n\n.fa-heart-circle-minus::before {\n  content: \"\\e4ff\";\n}\n\n.fa-hourglass-half::before {\n  content: \"\\f252\";\n}\n\n.fa-hourglass-2::before {\n  content: \"\\f252\";\n}\n\n.fa-microscope::before {\n  content: \"\\f610\";\n}\n\n.fa-sink::before {\n  content: \"\\e06d\";\n}\n\n.fa-bag-shopping::before {\n  content: \"\\f290\";\n}\n\n.fa-shopping-bag::before {\n  content: \"\\f290\";\n}\n\n.fa-arrow-down-z-a::before {\n  content: \"\\f881\";\n}\n\n.fa-sort-alpha-desc::before {\n  content: \"\\f881\";\n}\n\n.fa-sort-alpha-down-alt::before {\n  content: \"\\f881\";\n}\n\n.fa-mitten::before {\n  content: \"\\f7b5\";\n}\n\n.fa-person-rays::before {\n  content: \"\\e54d\";\n}\n\n.fa-users::before {\n  content: \"\\f0c0\";\n}\n\n.fa-eye-slash::before {\n  content: \"\\f070\";\n}\n\n.fa-flask-vial::before {\n  content: \"\\e4f3\";\n}\n\n.fa-hand::before {\n  content: \"\\f256\";\n}\n\n.fa-hand-paper::before {\n  content: \"\\f256\";\n}\n\n.fa-om::before {\n  content: \"\\f679\";\n}\n\n.fa-worm::before {\n  content: \"\\e599\";\n}\n\n.fa-house-circle-xmark::before {\n  content: \"\\e50b\";\n}\n\n.fa-plug::before {\n  content: \"\\f1e6\";\n}\n\n.fa-chevron-up::before {\n  content: \"\\f077\";\n}\n\n.fa-hand-spock::before {\n  content: \"\\f259\";\n}\n\n.fa-stopwatch::before {\n  content: \"\\f2f2\";\n}\n\n.fa-face-kiss::before {\n  content: \"\\f596\";\n}\n\n.fa-kiss::before {\n  content: \"\\f596\";\n}\n\n.fa-bridge-circle-xmark::before {\n  content: \"\\e4cb\";\n}\n\n.fa-face-grin-tongue::before {\n  content: \"\\f589\";\n}\n\n.fa-grin-tongue::before {\n  content: \"\\f589\";\n}\n\n.fa-chess-bishop::before {\n  content: \"\\f43a\";\n}\n\n.fa-face-grin-wink::before {\n  content: \"\\f58c\";\n}\n\n.fa-grin-wink::before {\n  content: \"\\f58c\";\n}\n\n.fa-ear-deaf::before {\n  content: \"\\f2a4\";\n}\n\n.fa-deaf::before {\n  content: \"\\f2a4\";\n}\n\n.fa-deafness::before {\n  content: \"\\f2a4\";\n}\n\n.fa-hard-of-hearing::before {\n  content: \"\\f2a4\";\n}\n\n.fa-road-circle-check::before {\n  content: \"\\e564\";\n}\n\n.fa-dice-five::before {\n  content: \"\\f523\";\n}\n\n.fa-square-rss::before {\n  content: \"\\f143\";\n}\n\n.fa-rss-square::before {\n  content: \"\\f143\";\n}\n\n.fa-land-mine-on::before {\n  content: \"\\e51b\";\n}\n\n.fa-i-cursor::before {\n  content: \"\\f246\";\n}\n\n.fa-stamp::before {\n  content: \"\\f5bf\";\n}\n\n.fa-stairs::before {\n  content: \"\\e289\";\n}\n\n.fa-i::before {\n  content: \"I\";\n}\n\n.fa-hryvnia-sign::before {\n  content: \"\\f6f2\";\n}\n\n.fa-hryvnia::before {\n  content: \"\\f6f2\";\n}\n\n.fa-pills::before {\n  content: \"\\f484\";\n}\n\n.fa-face-grin-wide::before {\n  content: \"\\f581\";\n}\n\n.fa-grin-alt::before {\n  content: \"\\f581\";\n}\n\n.fa-tooth::before {\n  content: \"\\f5c9\";\n}\n\n.fa-v::before {\n  content: \"V\";\n}\n\n.fa-bicycle::before {\n  content: \"\\f206\";\n}\n\n.fa-staff-snake::before {\n  content: \"\\e579\";\n}\n\n.fa-rod-asclepius::before {\n  content: \"\\e579\";\n}\n\n.fa-rod-snake::before {\n  content: \"\\e579\";\n}\n\n.fa-staff-aesculapius::before {\n  content: \"\\e579\";\n}\n\n.fa-head-side-cough-slash::before {\n  content: \"\\e062\";\n}\n\n.fa-truck-medical::before {\n  content: \"\\f0f9\";\n}\n\n.fa-ambulance::before {\n  content: \"\\f0f9\";\n}\n\n.fa-wheat-awn-circle-exclamation::before {\n  content: \"\\e598\";\n}\n\n.fa-snowman::before {\n  content: \"\\f7d0\";\n}\n\n.fa-mortar-pestle::before {\n  content: \"\\f5a7\";\n}\n\n.fa-road-barrier::before {\n  content: \"\\e562\";\n}\n\n.fa-school::before {\n  content: \"\\f549\";\n}\n\n.fa-igloo::before {\n  content: \"\\f7ae\";\n}\n\n.fa-joint::before {\n  content: \"\\f595\";\n}\n\n.fa-angle-right::before {\n  content: \"\\f105\";\n}\n\n.fa-horse::before {\n  content: \"\\f6f0\";\n}\n\n.fa-q::before {\n  content: \"Q\";\n}\n\n.fa-g::before {\n  content: \"G\";\n}\n\n.fa-notes-medical::before {\n  content: \"\\f481\";\n}\n\n.fa-temperature-half::before {\n  content: \"\\f2c9\";\n}\n\n.fa-temperature-2::before {\n  content: \"\\f2c9\";\n}\n\n.fa-thermometer-2::before {\n  content: \"\\f2c9\";\n}\n\n.fa-thermometer-half::before {\n  content: \"\\f2c9\";\n}\n\n.fa-dong-sign::before {\n  content: \"\\e169\";\n}\n\n.fa-capsules::before {\n  content: \"\\f46b\";\n}\n\n.fa-poo-storm::before {\n  content: \"\\f75a\";\n}\n\n.fa-poo-bolt::before {\n  content: \"\\f75a\";\n}\n\n.fa-face-frown-open::before {\n  content: \"\\f57a\";\n}\n\n.fa-frown-open::before {\n  content: \"\\f57a\";\n}\n\n.fa-hand-point-up::before {\n  content: \"\\f0a6\";\n}\n\n.fa-money-bill::before {\n  content: \"\\f0d6\";\n}\n\n.fa-bookmark::before {\n  content: \"\\f02e\";\n}\n\n.fa-align-justify::before {\n  content: \"\\f039\";\n}\n\n.fa-umbrella-beach::before {\n  content: \"\\f5ca\";\n}\n\n.fa-helmet-un::before {\n  content: \"\\e503\";\n}\n\n.fa-bullseye::before {\n  content: \"\\f140\";\n}\n\n.fa-bacon::before {\n  content: \"\\f7e5\";\n}\n\n.fa-hand-point-down::before {\n  content: \"\\f0a7\";\n}\n\n.fa-arrow-up-from-bracket::before {\n  content: \"\\e09a\";\n}\n\n.fa-folder::before {\n  content: \"\\f07b\";\n}\n\n.fa-folder-blank::before {\n  content: \"\\f07b\";\n}\n\n.fa-file-waveform::before {\n  content: \"\\f478\";\n}\n\n.fa-file-medical-alt::before {\n  content: \"\\f478\";\n}\n\n.fa-radiation::before {\n  content: \"\\f7b9\";\n}\n\n.fa-chart-simple::before {\n  content: \"\\e473\";\n}\n\n.fa-mars-stroke::before {\n  content: \"\\f229\";\n}\n\n.fa-vial::before {\n  content: \"\\f492\";\n}\n\n.fa-gauge::before {\n  content: \"\\f624\";\n}\n\n.fa-dashboard::before {\n  content: \"\\f624\";\n}\n\n.fa-gauge-med::before {\n  content: \"\\f624\";\n}\n\n.fa-tachometer-alt-average::before {\n  content: \"\\f624\";\n}\n\n.fa-wand-magic-sparkles::before {\n  content: \"\\e2ca\";\n}\n\n.fa-magic-wand-sparkles::before {\n  content: \"\\e2ca\";\n}\n\n.fa-e::before {\n  content: \"E\";\n}\n\n.fa-pen-clip::before {\n  content: \"\\f305\";\n}\n\n.fa-pen-alt::before {\n  content: \"\\f305\";\n}\n\n.fa-bridge-circle-exclamation::before {\n  content: \"\\e4ca\";\n}\n\n.fa-user::before {\n  content: \"\\f007\";\n}\n\n.fa-school-circle-check::before {\n  content: \"\\e56b\";\n}\n\n.fa-dumpster::before {\n  content: \"\\f793\";\n}\n\n.fa-van-shuttle::before {\n  content: \"\\f5b6\";\n}\n\n.fa-shuttle-van::before {\n  content: \"\\f5b6\";\n}\n\n.fa-building-user::before {\n  content: \"\\e4da\";\n}\n\n.fa-square-caret-left::before {\n  content: \"\\f191\";\n}\n\n.fa-caret-square-left::before {\n  content: \"\\f191\";\n}\n\n.fa-highlighter::before {\n  content: \"\\f591\";\n}\n\n.fa-key::before {\n  content: \"\\f084\";\n}\n\n.fa-bullhorn::before {\n  content: \"\\f0a1\";\n}\n\n.fa-globe::before {\n  content: \"\\f0ac\";\n}\n\n.fa-synagogue::before {\n  content: \"\\f69b\";\n}\n\n.fa-person-half-dress::before {\n  content: \"\\e548\";\n}\n\n.fa-road-bridge::before {\n  content: \"\\e563\";\n}\n\n.fa-location-arrow::before {\n  content: \"\\f124\";\n}\n\n.fa-c::before {\n  content: \"C\";\n}\n\n.fa-tablet-button::before {\n  content: \"\\f10a\";\n}\n\n.fa-building-lock::before {\n  content: \"\\e4d6\";\n}\n\n.fa-pizza-slice::before {\n  content: \"\\f818\";\n}\n\n.fa-money-bill-wave::before {\n  content: \"\\f53a\";\n}\n\n.fa-chart-area::before {\n  content: \"\\f1fe\";\n}\n\n.fa-area-chart::before {\n  content: \"\\f1fe\";\n}\n\n.fa-house-flag::before {\n  content: \"\\e50d\";\n}\n\n.fa-person-circle-minus::before {\n  content: \"\\e540\";\n}\n\n.fa-ban::before {\n  content: \"\\f05e\";\n}\n\n.fa-cancel::before {\n  content: \"\\f05e\";\n}\n\n.fa-camera-rotate::before {\n  content: \"\\e0d8\";\n}\n\n.fa-spray-can-sparkles::before {\n  content: \"\\f5d0\";\n}\n\n.fa-air-freshener::before {\n  content: \"\\f5d0\";\n}\n\n.fa-star::before {\n  content: \"\\f005\";\n}\n\n.fa-repeat::before {\n  content: \"\\f363\";\n}\n\n.fa-cross::before {\n  content: \"\\f654\";\n}\n\n.fa-box::before {\n  content: \"\\f466\";\n}\n\n.fa-venus-mars::before {\n  content: \"\\f228\";\n}\n\n.fa-arrow-pointer::before {\n  content: \"\\f245\";\n}\n\n.fa-mouse-pointer::before {\n  content: \"\\f245\";\n}\n\n.fa-maximize::before {\n  content: \"\\f31e\";\n}\n\n.fa-expand-arrows-alt::before {\n  content: \"\\f31e\";\n}\n\n.fa-charging-station::before {\n  content: \"\\f5e7\";\n}\n\n.fa-shapes::before {\n  content: \"\\f61f\";\n}\n\n.fa-triangle-circle-square::before {\n  content: \"\\f61f\";\n}\n\n.fa-shuffle::before {\n  content: \"\\f074\";\n}\n\n.fa-random::before {\n  content: \"\\f074\";\n}\n\n.fa-person-running::before {\n  content: \"\\f70c\";\n}\n\n.fa-running::before {\n  content: \"\\f70c\";\n}\n\n.fa-mobile-retro::before {\n  content: \"\\e527\";\n}\n\n.fa-grip-lines-vertical::before {\n  content: \"\\f7a5\";\n}\n\n.fa-spider::before {\n  content: \"\\f717\";\n}\n\n.fa-hands-bound::before {\n  content: \"\\e4f9\";\n}\n\n.fa-file-invoice-dollar::before {\n  content: \"\\f571\";\n}\n\n.fa-plane-circle-exclamation::before {\n  content: \"\\e556\";\n}\n\n.fa-x-ray::before {\n  content: \"\\f497\";\n}\n\n.fa-spell-check::before {\n  content: \"\\f891\";\n}\n\n.fa-slash::before {\n  content: \"\\f715\";\n}\n\n.fa-computer-mouse::before {\n  content: \"\\f8cc\";\n}\n\n.fa-mouse::before {\n  content: \"\\f8cc\";\n}\n\n.fa-arrow-right-to-bracket::before {\n  content: \"\\f090\";\n}\n\n.fa-sign-in::before {\n  content: \"\\f090\";\n}\n\n.fa-shop-slash::before {\n  content: \"\\e070\";\n}\n\n.fa-store-alt-slash::before {\n  content: \"\\e070\";\n}\n\n.fa-server::before {\n  content: \"\\f233\";\n}\n\n.fa-virus-covid-slash::before {\n  content: \"\\e4a9\";\n}\n\n.fa-shop-lock::before {\n  content: \"\\e4a5\";\n}\n\n.fa-hourglass-start::before {\n  content: \"\\f251\";\n}\n\n.fa-hourglass-1::before {\n  content: \"\\f251\";\n}\n\n.fa-blender-phone::before {\n  content: \"\\f6b6\";\n}\n\n.fa-building-wheat::before {\n  content: \"\\e4db\";\n}\n\n.fa-person-breastfeeding::before {\n  content: \"\\e53a\";\n}\n\n.fa-right-to-bracket::before {\n  content: \"\\f2f6\";\n}\n\n.fa-sign-in-alt::before {\n  content: \"\\f2f6\";\n}\n\n.fa-venus::before {\n  content: \"\\f221\";\n}\n\n.fa-passport::before {\n  content: \"\\f5ab\";\n}\n\n.fa-heart-pulse::before {\n  content: \"\\f21e\";\n}\n\n.fa-heartbeat::before {\n  content: \"\\f21e\";\n}\n\n.fa-people-carry-box::before {\n  content: \"\\f4ce\";\n}\n\n.fa-people-carry::before {\n  content: \"\\f4ce\";\n}\n\n.fa-temperature-high::before {\n  content: \"\\f769\";\n}\n\n.fa-microchip::before {\n  content: \"\\f2db\";\n}\n\n.fa-crown::before {\n  content: \"\\f521\";\n}\n\n.fa-weight-hanging::before {\n  content: \"\\f5cd\";\n}\n\n.fa-xmarks-lines::before {\n  content: \"\\e59a\";\n}\n\n.fa-file-prescription::before {\n  content: \"\\f572\";\n}\n\n.fa-weight-scale::before {\n  content: \"\\f496\";\n}\n\n.fa-weight::before {\n  content: \"\\f496\";\n}\n\n.fa-user-group::before {\n  content: \"\\f500\";\n}\n\n.fa-user-friends::before {\n  content: \"\\f500\";\n}\n\n.fa-arrow-up-a-z::before {\n  content: \"\\f15e\";\n}\n\n.fa-sort-alpha-up::before {\n  content: \"\\f15e\";\n}\n\n.fa-chess-knight::before {\n  content: \"\\f441\";\n}\n\n.fa-face-laugh-squint::before {\n  content: \"\\f59b\";\n}\n\n.fa-laugh-squint::before {\n  content: \"\\f59b\";\n}\n\n.fa-wheelchair::before {\n  content: \"\\f193\";\n}\n\n.fa-circle-arrow-up::before {\n  content: \"\\f0aa\";\n}\n\n.fa-arrow-circle-up::before {\n  content: \"\\f0aa\";\n}\n\n.fa-toggle-on::before {\n  content: \"\\f205\";\n}\n\n.fa-person-walking::before {\n  content: \"\\f554\";\n}\n\n.fa-walking::before {\n  content: \"\\f554\";\n}\n\n.fa-l::before {\n  content: \"L\";\n}\n\n.fa-fire::before {\n  content: \"\\f06d\";\n}\n\n.fa-bed-pulse::before {\n  content: \"\\f487\";\n}\n\n.fa-procedures::before {\n  content: \"\\f487\";\n}\n\n.fa-shuttle-space::before {\n  content: \"\\f197\";\n}\n\n.fa-space-shuttle::before {\n  content: \"\\f197\";\n}\n\n.fa-face-laugh::before {\n  content: \"\\f599\";\n}\n\n.fa-laugh::before {\n  content: \"\\f599\";\n}\n\n.fa-folder-open::before {\n  content: \"\\f07c\";\n}\n\n.fa-heart-circle-plus::before {\n  content: \"\\e500\";\n}\n\n.fa-code-fork::before {\n  content: \"\\e13b\";\n}\n\n.fa-city::before {\n  content: \"\\f64f\";\n}\n\n.fa-microphone-lines::before {\n  content: \"\\f3c9\";\n}\n\n.fa-microphone-alt::before {\n  content: \"\\f3c9\";\n}\n\n.fa-pepper-hot::before {\n  content: \"\\f816\";\n}\n\n.fa-unlock::before {\n  content: \"\\f09c\";\n}\n\n.fa-colon-sign::before {\n  content: \"\\e140\";\n}\n\n.fa-headset::before {\n  content: \"\\f590\";\n}\n\n.fa-store-slash::before {\n  content: \"\\e071\";\n}\n\n.fa-road-circle-xmark::before {\n  content: \"\\e566\";\n}\n\n.fa-user-minus::before {\n  content: \"\\f503\";\n}\n\n.fa-mars-stroke-up::before {\n  content: \"\\f22a\";\n}\n\n.fa-mars-stroke-v::before {\n  content: \"\\f22a\";\n}\n\n.fa-champagne-glasses::before {\n  content: \"\\f79f\";\n}\n\n.fa-glass-cheers::before {\n  content: \"\\f79f\";\n}\n\n.fa-clipboard::before {\n  content: \"\\f328\";\n}\n\n.fa-house-circle-exclamation::before {\n  content: \"\\e50a\";\n}\n\n.fa-file-arrow-up::before {\n  content: \"\\f574\";\n}\n\n.fa-file-upload::before {\n  content: \"\\f574\";\n}\n\n.fa-wifi::before {\n  content: \"\\f1eb\";\n}\n\n.fa-wifi-3::before {\n  content: \"\\f1eb\";\n}\n\n.fa-wifi-strong::before {\n  content: \"\\f1eb\";\n}\n\n.fa-bath::before {\n  content: \"\\f2cd\";\n}\n\n.fa-bathtub::before {\n  content: \"\\f2cd\";\n}\n\n.fa-underline::before {\n  content: \"\\f0cd\";\n}\n\n.fa-user-pen::before {\n  content: \"\\f4ff\";\n}\n\n.fa-user-edit::before {\n  content: \"\\f4ff\";\n}\n\n.fa-signature::before {\n  content: \"\\f5b7\";\n}\n\n.fa-stroopwafel::before {\n  content: \"\\f551\";\n}\n\n.fa-bold::before {\n  content: \"\\f032\";\n}\n\n.fa-anchor-lock::before {\n  content: \"\\e4ad\";\n}\n\n.fa-building-ngo::before {\n  content: \"\\e4d7\";\n}\n\n.fa-manat-sign::before {\n  content: \"\\e1d5\";\n}\n\n.fa-not-equal::before {\n  content: \"\\f53e\";\n}\n\n.fa-border-top-left::before {\n  content: \"\\f853\";\n}\n\n.fa-border-style::before {\n  content: \"\\f853\";\n}\n\n.fa-map-location-dot::before {\n  content: \"\\f5a0\";\n}\n\n.fa-map-marked-alt::before {\n  content: \"\\f5a0\";\n}\n\n.fa-jedi::before {\n  content: \"\\f669\";\n}\n\n.fa-square-poll-vertical::before {\n  content: \"\\f681\";\n}\n\n.fa-poll::before {\n  content: \"\\f681\";\n}\n\n.fa-mug-hot::before {\n  content: \"\\f7b6\";\n}\n\n.fa-car-battery::before {\n  content: \"\\f5df\";\n}\n\n.fa-battery-car::before {\n  content: \"\\f5df\";\n}\n\n.fa-gift::before {\n  content: \"\\f06b\";\n}\n\n.fa-dice-two::before {\n  content: \"\\f528\";\n}\n\n.fa-chess-queen::before {\n  content: \"\\f445\";\n}\n\n.fa-glasses::before {\n  content: \"\\f530\";\n}\n\n.fa-chess-board::before {\n  content: \"\\f43c\";\n}\n\n.fa-building-circle-check::before {\n  content: \"\\e4d2\";\n}\n\n.fa-person-chalkboard::before {\n  content: \"\\e53d\";\n}\n\n.fa-mars-stroke-right::before {\n  content: \"\\f22b\";\n}\n\n.fa-mars-stroke-h::before {\n  content: \"\\f22b\";\n}\n\n.fa-hand-back-fist::before {\n  content: \"\\f255\";\n}\n\n.fa-hand-rock::before {\n  content: \"\\f255\";\n}\n\n.fa-square-caret-up::before {\n  content: \"\\f151\";\n}\n\n.fa-caret-square-up::before {\n  content: \"\\f151\";\n}\n\n.fa-cloud-showers-water::before {\n  content: \"\\e4e4\";\n}\n\n.fa-chart-bar::before {\n  content: \"\\f080\";\n}\n\n.fa-bar-chart::before {\n  content: \"\\f080\";\n}\n\n.fa-hands-bubbles::before {\n  content: \"\\e05e\";\n}\n\n.fa-hands-wash::before {\n  content: \"\\e05e\";\n}\n\n.fa-less-than-equal::before {\n  content: \"\\f537\";\n}\n\n.fa-train::before {\n  content: \"\\f238\";\n}\n\n.fa-eye-low-vision::before {\n  content: \"\\f2a8\";\n}\n\n.fa-low-vision::before {\n  content: \"\\f2a8\";\n}\n\n.fa-crow::before {\n  content: \"\\f520\";\n}\n\n.fa-sailboat::before {\n  content: \"\\e445\";\n}\n\n.fa-window-restore::before {\n  content: \"\\f2d2\";\n}\n\n.fa-square-plus::before {\n  content: \"\\f0fe\";\n}\n\n.fa-plus-square::before {\n  content: \"\\f0fe\";\n}\n\n.fa-torii-gate::before {\n  content: \"\\f6a1\";\n}\n\n.fa-frog::before {\n  content: \"\\f52e\";\n}\n\n.fa-bucket::before {\n  content: \"\\e4cf\";\n}\n\n.fa-image::before {\n  content: \"\\f03e\";\n}\n\n.fa-microphone::before {\n  content: \"\\f130\";\n}\n\n.fa-cow::before {\n  content: \"\\f6c8\";\n}\n\n.fa-caret-up::before {\n  content: \"\\f0d8\";\n}\n\n.fa-screwdriver::before {\n  content: \"\\f54a\";\n}\n\n.fa-folder-closed::before {\n  content: \"\\e185\";\n}\n\n.fa-house-tsunami::before {\n  content: \"\\e515\";\n}\n\n.fa-square-nfi::before {\n  content: \"\\e576\";\n}\n\n.fa-arrow-up-from-ground-water::before {\n  content: \"\\e4b5\";\n}\n\n.fa-martini-glass::before {\n  content: \"\\f57b\";\n}\n\n.fa-glass-martini-alt::before {\n  content: \"\\f57b\";\n}\n\n.fa-rotate-left::before {\n  content: \"\\f2ea\";\n}\n\n.fa-rotate-back::before {\n  content: \"\\f2ea\";\n}\n\n.fa-rotate-backward::before {\n  content: \"\\f2ea\";\n}\n\n.fa-undo-alt::before {\n  content: \"\\f2ea\";\n}\n\n.fa-table-columns::before {\n  content: \"\\f0db\";\n}\n\n.fa-columns::before {\n  content: \"\\f0db\";\n}\n\n.fa-lemon::before {\n  content: \"\\f094\";\n}\n\n.fa-head-side-mask::before {\n  content: \"\\e063\";\n}\n\n.fa-handshake::before {\n  content: \"\\f2b5\";\n}\n\n.fa-gem::before {\n  content: \"\\f3a5\";\n}\n\n.fa-dolly::before {\n  content: \"\\f472\";\n}\n\n.fa-dolly-box::before {\n  content: \"\\f472\";\n}\n\n.fa-smoking::before {\n  content: \"\\f48d\";\n}\n\n.fa-minimize::before {\n  content: \"\\f78c\";\n}\n\n.fa-compress-arrows-alt::before {\n  content: \"\\f78c\";\n}\n\n.fa-monument::before {\n  content: \"\\f5a6\";\n}\n\n.fa-snowplow::before {\n  content: \"\\f7d2\";\n}\n\n.fa-angles-right::before {\n  content: \"\\f101\";\n}\n\n.fa-angle-double-right::before {\n  content: \"\\f101\";\n}\n\n.fa-cannabis::before {\n  content: \"\\f55f\";\n}\n\n.fa-circle-play::before {\n  content: \"\\f144\";\n}\n\n.fa-play-circle::before {\n  content: \"\\f144\";\n}\n\n.fa-tablets::before {\n  content: \"\\f490\";\n}\n\n.fa-ethernet::before {\n  content: \"\\f796\";\n}\n\n.fa-euro-sign::before {\n  content: \"\\f153\";\n}\n\n.fa-eur::before {\n  content: \"\\f153\";\n}\n\n.fa-euro::before {\n  content: \"\\f153\";\n}\n\n.fa-chair::before {\n  content: \"\\f6c0\";\n}\n\n.fa-circle-check::before {\n  content: \"\\f058\";\n}\n\n.fa-check-circle::before {\n  content: \"\\f058\";\n}\n\n.fa-circle-stop::before {\n  content: \"\\f28d\";\n}\n\n.fa-stop-circle::before {\n  content: \"\\f28d\";\n}\n\n.fa-compass-drafting::before {\n  content: \"\\f568\";\n}\n\n.fa-drafting-compass::before {\n  content: \"\\f568\";\n}\n\n.fa-plate-wheat::before {\n  content: \"\\e55a\";\n}\n\n.fa-icicles::before {\n  content: \"\\f7ad\";\n}\n\n.fa-person-shelter::before {\n  content: \"\\e54f\";\n}\n\n.fa-neuter::before {\n  content: \"\\f22c\";\n}\n\n.fa-id-badge::before {\n  content: \"\\f2c1\";\n}\n\n.fa-marker::before {\n  content: \"\\f5a1\";\n}\n\n.fa-face-laugh-beam::before {\n  content: \"\\f59a\";\n}\n\n.fa-laugh-beam::before {\n  content: \"\\f59a\";\n}\n\n.fa-helicopter-symbol::before {\n  content: \"\\e502\";\n}\n\n.fa-universal-access::before {\n  content: \"\\f29a\";\n}\n\n.fa-circle-chevron-up::before {\n  content: \"\\f139\";\n}\n\n.fa-chevron-circle-up::before {\n  content: \"\\f139\";\n}\n\n.fa-lari-sign::before {\n  content: \"\\e1c8\";\n}\n\n.fa-volcano::before {\n  content: \"\\f770\";\n}\n\n.fa-person-walking-dashed-line-arrow-right::before {\n  content: \"\\e553\";\n}\n\n.fa-sterling-sign::before {\n  content: \"\\f154\";\n}\n\n.fa-gbp::before {\n  content: \"\\f154\";\n}\n\n.fa-pound-sign::before {\n  content: \"\\f154\";\n}\n\n.fa-viruses::before {\n  content: \"\\e076\";\n}\n\n.fa-square-person-confined::before {\n  content: \"\\e577\";\n}\n\n.fa-user-tie::before {\n  content: \"\\f508\";\n}\n\n.fa-arrow-down-long::before {\n  content: \"\\f175\";\n}\n\n.fa-long-arrow-down::before {\n  content: \"\\f175\";\n}\n\n.fa-tent-arrow-down-to-line::before {\n  content: \"\\e57e\";\n}\n\n.fa-certificate::before {\n  content: \"\\f0a3\";\n}\n\n.fa-reply-all::before {\n  content: \"\\f122\";\n}\n\n.fa-mail-reply-all::before {\n  content: \"\\f122\";\n}\n\n.fa-suitcase::before {\n  content: \"\\f0f2\";\n}\n\n.fa-person-skating::before {\n  content: \"\\f7c5\";\n}\n\n.fa-skating::before {\n  content: \"\\f7c5\";\n}\n\n.fa-filter-circle-dollar::before {\n  content: \"\\f662\";\n}\n\n.fa-funnel-dollar::before {\n  content: \"\\f662\";\n}\n\n.fa-camera-retro::before {\n  content: \"\\f083\";\n}\n\n.fa-circle-arrow-down::before {\n  content: \"\\f0ab\";\n}\n\n.fa-arrow-circle-down::before {\n  content: \"\\f0ab\";\n}\n\n.fa-file-import::before {\n  content: \"\\f56f\";\n}\n\n.fa-arrow-right-to-file::before {\n  content: \"\\f56f\";\n}\n\n.fa-square-arrow-up-right::before {\n  content: \"\\f14c\";\n}\n\n.fa-external-link-square::before {\n  content: \"\\f14c\";\n}\n\n.fa-box-open::before {\n  content: \"\\f49e\";\n}\n\n.fa-scroll::before {\n  content: \"\\f70e\";\n}\n\n.fa-spa::before {\n  content: \"\\f5bb\";\n}\n\n.fa-location-pin-lock::before {\n  content: \"\\e51f\";\n}\n\n.fa-pause::before {\n  content: \"\\f04c\";\n}\n\n.fa-hill-avalanche::before {\n  content: \"\\e507\";\n}\n\n.fa-temperature-empty::before {\n  content: \"\\f2cb\";\n}\n\n.fa-temperature-0::before {\n  content: \"\\f2cb\";\n}\n\n.fa-thermometer-0::before {\n  content: \"\\f2cb\";\n}\n\n.fa-thermometer-empty::before {\n  content: \"\\f2cb\";\n}\n\n.fa-bomb::before {\n  content: \"\\f1e2\";\n}\n\n.fa-registered::before {\n  content: \"\\f25d\";\n}\n\n.fa-address-card::before {\n  content: \"\\f2bb\";\n}\n\n.fa-contact-card::before {\n  content: \"\\f2bb\";\n}\n\n.fa-vcard::before {\n  content: \"\\f2bb\";\n}\n\n.fa-scale-unbalanced-flip::before {\n  content: \"\\f516\";\n}\n\n.fa-balance-scale-right::before {\n  content: \"\\f516\";\n}\n\n.fa-subscript::before {\n  content: \"\\f12c\";\n}\n\n.fa-diamond-turn-right::before {\n  content: \"\\f5eb\";\n}\n\n.fa-directions::before {\n  content: \"\\f5eb\";\n}\n\n.fa-burst::before {\n  content: \"\\e4dc\";\n}\n\n.fa-house-laptop::before {\n  content: \"\\e066\";\n}\n\n.fa-laptop-house::before {\n  content: \"\\e066\";\n}\n\n.fa-face-tired::before {\n  content: \"\\f5c8\";\n}\n\n.fa-tired::before {\n  content: \"\\f5c8\";\n}\n\n.fa-money-bills::before {\n  content: \"\\e1f3\";\n}\n\n.fa-smog::before {\n  content: \"\\f75f\";\n}\n\n.fa-crutch::before {\n  content: \"\\f7f7\";\n}\n\n.fa-cloud-arrow-up::before {\n  content: \"\\f0ee\";\n}\n\n.fa-cloud-upload::before {\n  content: \"\\f0ee\";\n}\n\n.fa-cloud-upload-alt::before {\n  content: \"\\f0ee\";\n}\n\n.fa-palette::before {\n  content: \"\\f53f\";\n}\n\n.fa-arrows-turn-right::before {\n  content: \"\\e4c0\";\n}\n\n.fa-vest::before {\n  content: \"\\e085\";\n}\n\n.fa-ferry::before {\n  content: \"\\e4ea\";\n}\n\n.fa-arrows-down-to-people::before {\n  content: \"\\e4b9\";\n}\n\n.fa-seedling::before {\n  content: \"\\f4d8\";\n}\n\n.fa-sprout::before {\n  content: \"\\f4d8\";\n}\n\n.fa-left-right::before {\n  content: \"\\f337\";\n}\n\n.fa-arrows-alt-h::before {\n  content: \"\\f337\";\n}\n\n.fa-boxes-packing::before {\n  content: \"\\e4c7\";\n}\n\n.fa-circle-arrow-left::before {\n  content: \"\\f0a8\";\n}\n\n.fa-arrow-circle-left::before {\n  content: \"\\f0a8\";\n}\n\n.fa-group-arrows-rotate::before {\n  content: \"\\e4f6\";\n}\n\n.fa-bowl-food::before {\n  content: \"\\e4c6\";\n}\n\n.fa-candy-cane::before {\n  content: \"\\f786\";\n}\n\n.fa-arrow-down-wide-short::before {\n  content: \"\\f160\";\n}\n\n.fa-sort-amount-asc::before {\n  content: \"\\f160\";\n}\n\n.fa-sort-amount-down::before {\n  content: \"\\f160\";\n}\n\n.fa-cloud-bolt::before {\n  content: \"\\f76c\";\n}\n\n.fa-thunderstorm::before {\n  content: \"\\f76c\";\n}\n\n.fa-text-slash::before {\n  content: \"\\f87d\";\n}\n\n.fa-remove-format::before {\n  content: \"\\f87d\";\n}\n\n.fa-face-smile-wink::before {\n  content: \"\\f4da\";\n}\n\n.fa-smile-wink::before {\n  content: \"\\f4da\";\n}\n\n.fa-file-word::before {\n  content: \"\\f1c2\";\n}\n\n.fa-file-powerpoint::before {\n  content: \"\\f1c4\";\n}\n\n.fa-arrows-left-right::before {\n  content: \"\\f07e\";\n}\n\n.fa-arrows-h::before {\n  content: \"\\f07e\";\n}\n\n.fa-house-lock::before {\n  content: \"\\e510\";\n}\n\n.fa-cloud-arrow-down::before {\n  content: \"\\f0ed\";\n}\n\n.fa-cloud-download::before {\n  content: \"\\f0ed\";\n}\n\n.fa-cloud-download-alt::before {\n  content: \"\\f0ed\";\n}\n\n.fa-children::before {\n  content: \"\\e4e1\";\n}\n\n.fa-chalkboard::before {\n  content: \"\\f51b\";\n}\n\n.fa-blackboard::before {\n  content: \"\\f51b\";\n}\n\n.fa-user-large-slash::before {\n  content: \"\\f4fa\";\n}\n\n.fa-user-alt-slash::before {\n  content: \"\\f4fa\";\n}\n\n.fa-envelope-open::before {\n  content: \"\\f2b6\";\n}\n\n.fa-handshake-simple-slash::before {\n  content: \"\\e05f\";\n}\n\n.fa-handshake-alt-slash::before {\n  content: \"\\e05f\";\n}\n\n.fa-mattress-pillow::before {\n  content: \"\\e525\";\n}\n\n.fa-guarani-sign::before {\n  content: \"\\e19a\";\n}\n\n.fa-arrows-rotate::before {\n  content: \"\\f021\";\n}\n\n.fa-refresh::before {\n  content: \"\\f021\";\n}\n\n.fa-sync::before {\n  content: \"\\f021\";\n}\n\n.fa-fire-extinguisher::before {\n  content: \"\\f134\";\n}\n\n.fa-cruzeiro-sign::before {\n  content: \"\\e152\";\n}\n\n.fa-greater-than-equal::before {\n  content: \"\\f532\";\n}\n\n.fa-shield-halved::before {\n  content: \"\\f3ed\";\n}\n\n.fa-shield-alt::before {\n  content: \"\\f3ed\";\n}\n\n.fa-book-atlas::before {\n  content: \"\\f558\";\n}\n\n.fa-atlas::before {\n  content: \"\\f558\";\n}\n\n.fa-virus::before {\n  content: \"\\e074\";\n}\n\n.fa-envelope-circle-check::before {\n  content: \"\\e4e8\";\n}\n\n.fa-layer-group::before {\n  content: \"\\f5fd\";\n}\n\n.fa-arrows-to-dot::before {\n  content: \"\\e4be\";\n}\n\n.fa-archway::before {\n  content: \"\\f557\";\n}\n\n.fa-heart-circle-check::before {\n  content: \"\\e4fd\";\n}\n\n.fa-house-chimney-crack::before {\n  content: \"\\f6f1\";\n}\n\n.fa-house-damage::before {\n  content: \"\\f6f1\";\n}\n\n.fa-file-zipper::before {\n  content: \"\\f1c6\";\n}\n\n.fa-file-archive::before {\n  content: \"\\f1c6\";\n}\n\n.fa-square::before {\n  content: \"\\f0c8\";\n}\n\n.fa-martini-glass-empty::before {\n  content: \"\\f000\";\n}\n\n.fa-glass-martini::before {\n  content: \"\\f000\";\n}\n\n.fa-couch::before {\n  content: \"\\f4b8\";\n}\n\n.fa-cedi-sign::before {\n  content: \"\\e0df\";\n}\n\n.fa-italic::before {\n  content: \"\\f033\";\n}\n\n.fa-church::before {\n  content: \"\\f51d\";\n}\n\n.fa-comments-dollar::before {\n  content: \"\\f653\";\n}\n\n.fa-democrat::before {\n  content: \"\\f747\";\n}\n\n.fa-z::before {\n  content: \"Z\";\n}\n\n.fa-person-skiing::before {\n  content: \"\\f7c9\";\n}\n\n.fa-skiing::before {\n  content: \"\\f7c9\";\n}\n\n.fa-road-lock::before {\n  content: \"\\e567\";\n}\n\n.fa-a::before {\n  content: \"A\";\n}\n\n.fa-temperature-arrow-down::before {\n  content: \"\\e03f\";\n}\n\n.fa-temperature-down::before {\n  content: \"\\e03f\";\n}\n\n.fa-feather-pointed::before {\n  content: \"\\f56b\";\n}\n\n.fa-feather-alt::before {\n  content: \"\\f56b\";\n}\n\n.fa-p::before {\n  content: \"P\";\n}\n\n.fa-snowflake::before {\n  content: \"\\f2dc\";\n}\n\n.fa-newspaper::before {\n  content: \"\\f1ea\";\n}\n\n.fa-rectangle-ad::before {\n  content: \"\\f641\";\n}\n\n.fa-ad::before {\n  content: \"\\f641\";\n}\n\n.fa-circle-arrow-right::before {\n  content: \"\\f0a9\";\n}\n\n.fa-arrow-circle-right::before {\n  content: \"\\f0a9\";\n}\n\n.fa-filter-circle-xmark::before {\n  content: \"\\e17b\";\n}\n\n.fa-locust::before {\n  content: \"\\e520\";\n}\n\n.fa-sort::before {\n  content: \"\\f0dc\";\n}\n\n.fa-unsorted::before {\n  content: \"\\f0dc\";\n}\n\n.fa-list-ol::before {\n  content: \"\\f0cb\";\n}\n\n.fa-list-1-2::before {\n  content: \"\\f0cb\";\n}\n\n.fa-list-numeric::before {\n  content: \"\\f0cb\";\n}\n\n.fa-person-dress-burst::before {\n  content: \"\\e544\";\n}\n\n.fa-money-check-dollar::before {\n  content: \"\\f53d\";\n}\n\n.fa-money-check-alt::before {\n  content: \"\\f53d\";\n}\n\n.fa-vector-square::before {\n  content: \"\\f5cb\";\n}\n\n.fa-bread-slice::before {\n  content: \"\\f7ec\";\n}\n\n.fa-language::before {\n  content: \"\\f1ab\";\n}\n\n.fa-face-kiss-wink-heart::before {\n  content: \"\\f598\";\n}\n\n.fa-kiss-wink-heart::before {\n  content: \"\\f598\";\n}\n\n.fa-filter::before {\n  content: \"\\f0b0\";\n}\n\n.fa-question::before {\n  content: \"\\?\";\n}\n\n.fa-file-signature::before {\n  content: \"\\f573\";\n}\n\n.fa-up-down-left-right::before {\n  content: \"\\f0b2\";\n}\n\n.fa-arrows-alt::before {\n  content: \"\\f0b2\";\n}\n\n.fa-house-chimney-user::before {\n  content: \"\\e065\";\n}\n\n.fa-hand-holding-heart::before {\n  content: \"\\f4be\";\n}\n\n.fa-puzzle-piece::before {\n  content: \"\\f12e\";\n}\n\n.fa-money-check::before {\n  content: \"\\f53c\";\n}\n\n.fa-star-half-stroke::before {\n  content: \"\\f5c0\";\n}\n\n.fa-star-half-alt::before {\n  content: \"\\f5c0\";\n}\n\n.fa-code::before {\n  content: \"\\f121\";\n}\n\n.fa-whiskey-glass::before {\n  content: \"\\f7a0\";\n}\n\n.fa-glass-whiskey::before {\n  content: \"\\f7a0\";\n}\n\n.fa-building-circle-exclamation::before {\n  content: \"\\e4d3\";\n}\n\n.fa-magnifying-glass-chart::before {\n  content: \"\\e522\";\n}\n\n.fa-arrow-up-right-from-square::before {\n  content: \"\\f08e\";\n}\n\n.fa-external-link::before {\n  content: \"\\f08e\";\n}\n\n.fa-cubes-stacked::before {\n  content: \"\\e4e6\";\n}\n\n.fa-won-sign::before {\n  content: \"\\f159\";\n}\n\n.fa-krw::before {\n  content: \"\\f159\";\n}\n\n.fa-won::before {\n  content: \"\\f159\";\n}\n\n.fa-virus-covid::before {\n  content: \"\\e4a8\";\n}\n\n.fa-austral-sign::before {\n  content: \"\\e0a9\";\n}\n\n.fa-f::before {\n  content: \"F\";\n}\n\n.fa-leaf::before {\n  content: \"\\f06c\";\n}\n\n.fa-road::before {\n  content: \"\\f018\";\n}\n\n.fa-taxi::before {\n  content: \"\\f1ba\";\n}\n\n.fa-cab::before {\n  content: \"\\f1ba\";\n}\n\n.fa-person-circle-plus::before {\n  content: \"\\e541\";\n}\n\n.fa-chart-pie::before {\n  content: \"\\f200\";\n}\n\n.fa-pie-chart::before {\n  content: \"\\f200\";\n}\n\n.fa-bolt-lightning::before {\n  content: \"\\e0b7\";\n}\n\n.fa-sack-xmark::before {\n  content: \"\\e56a\";\n}\n\n.fa-file-excel::before {\n  content: \"\\f1c3\";\n}\n\n.fa-file-contract::before {\n  content: \"\\f56c\";\n}\n\n.fa-fish-fins::before {\n  content: \"\\e4f2\";\n}\n\n.fa-building-flag::before {\n  content: \"\\e4d5\";\n}\n\n.fa-face-grin-beam::before {\n  content: \"\\f582\";\n}\n\n.fa-grin-beam::before {\n  content: \"\\f582\";\n}\n\n.fa-object-ungroup::before {\n  content: \"\\f248\";\n}\n\n.fa-poop::before {\n  content: \"\\f619\";\n}\n\n.fa-location-pin::before {\n  content: \"\\f041\";\n}\n\n.fa-map-marker::before {\n  content: \"\\f041\";\n}\n\n.fa-kaaba::before {\n  content: \"\\f66b\";\n}\n\n.fa-toilet-paper::before {\n  content: \"\\f71e\";\n}\n\n.fa-helmet-safety::before {\n  content: \"\\f807\";\n}\n\n.fa-hard-hat::before {\n  content: \"\\f807\";\n}\n\n.fa-hat-hard::before {\n  content: \"\\f807\";\n}\n\n.fa-eject::before {\n  content: \"\\f052\";\n}\n\n.fa-circle-right::before {\n  content: \"\\f35a\";\n}\n\n.fa-arrow-alt-circle-right::before {\n  content: \"\\f35a\";\n}\n\n.fa-plane-circle-check::before {\n  content: \"\\e555\";\n}\n\n.fa-face-rolling-eyes::before {\n  content: \"\\f5a5\";\n}\n\n.fa-meh-rolling-eyes::before {\n  content: \"\\f5a5\";\n}\n\n.fa-object-group::before {\n  content: \"\\f247\";\n}\n\n.fa-chart-line::before {\n  content: \"\\f201\";\n}\n\n.fa-line-chart::before {\n  content: \"\\f201\";\n}\n\n.fa-mask-ventilator::before {\n  content: \"\\e524\";\n}\n\n.fa-arrow-right::before {\n  content: \"\\f061\";\n}\n\n.fa-signs-post::before {\n  content: \"\\f277\";\n}\n\n.fa-map-signs::before {\n  content: \"\\f277\";\n}\n\n.fa-cash-register::before {\n  content: \"\\f788\";\n}\n\n.fa-person-circle-question::before {\n  content: \"\\e542\";\n}\n\n.fa-h::before {\n  content: \"H\";\n}\n\n.fa-tarp::before {\n  content: \"\\e57b\";\n}\n\n.fa-screwdriver-wrench::before {\n  content: \"\\f7d9\";\n}\n\n.fa-tools::before {\n  content: \"\\f7d9\";\n}\n\n.fa-arrows-to-eye::before {\n  content: \"\\e4bf\";\n}\n\n.fa-plug-circle-bolt::before {\n  content: \"\\e55b\";\n}\n\n.fa-heart::before {\n  content: \"\\f004\";\n}\n\n.fa-mars-and-venus::before {\n  content: \"\\f224\";\n}\n\n.fa-house-user::before {\n  content: \"\\e1b0\";\n}\n\n.fa-home-user::before {\n  content: \"\\e1b0\";\n}\n\n.fa-dumpster-fire::before {\n  content: \"\\f794\";\n}\n\n.fa-house-crack::before {\n  content: \"\\e3b1\";\n}\n\n.fa-martini-glass-citrus::before {\n  content: \"\\f561\";\n}\n\n.fa-cocktail::before {\n  content: \"\\f561\";\n}\n\n.fa-face-surprise::before {\n  content: \"\\f5c2\";\n}\n\n.fa-surprise::before {\n  content: \"\\f5c2\";\n}\n\n.fa-bottle-water::before {\n  content: \"\\e4c5\";\n}\n\n.fa-circle-pause::before {\n  content: \"\\f28b\";\n}\n\n.fa-pause-circle::before {\n  content: \"\\f28b\";\n}\n\n.fa-toilet-paper-slash::before {\n  content: \"\\e072\";\n}\n\n.fa-apple-whole::before {\n  content: \"\\f5d1\";\n}\n\n.fa-apple-alt::before {\n  content: \"\\f5d1\";\n}\n\n.fa-kitchen-set::before {\n  content: \"\\e51a\";\n}\n\n.fa-r::before {\n  content: \"R\";\n}\n\n.fa-temperature-quarter::before {\n  content: \"\\f2ca\";\n}\n\n.fa-temperature-1::before {\n  content: \"\\f2ca\";\n}\n\n.fa-thermometer-1::before {\n  content: \"\\f2ca\";\n}\n\n.fa-thermometer-quarter::before {\n  content: \"\\f2ca\";\n}\n\n.fa-cube::before {\n  content: \"\\f1b2\";\n}\n\n.fa-bitcoin-sign::before {\n  content: \"\\e0b4\";\n}\n\n.fa-shield-dog::before {\n  content: \"\\e573\";\n}\n\n.fa-solar-panel::before {\n  content: \"\\f5ba\";\n}\n\n.fa-lock-open::before {\n  content: \"\\f3c1\";\n}\n\n.fa-elevator::before {\n  content: \"\\e16d\";\n}\n\n.fa-money-bill-transfer::before {\n  content: \"\\e528\";\n}\n\n.fa-money-bill-trend-up::before {\n  content: \"\\e529\";\n}\n\n.fa-house-flood-water-circle-arrow-right::before {\n  content: \"\\e50f\";\n}\n\n.fa-square-poll-horizontal::before {\n  content: \"\\f682\";\n}\n\n.fa-poll-h::before {\n  content: \"\\f682\";\n}\n\n.fa-circle::before {\n  content: \"\\f111\";\n}\n\n.fa-backward-fast::before {\n  content: \"\\f049\";\n}\n\n.fa-fast-backward::before {\n  content: \"\\f049\";\n}\n\n.fa-recycle::before {\n  content: \"\\f1b8\";\n}\n\n.fa-user-astronaut::before {\n  content: \"\\f4fb\";\n}\n\n.fa-plane-slash::before {\n  content: \"\\e069\";\n}\n\n.fa-trademark::before {\n  content: \"\\f25c\";\n}\n\n.fa-basketball::before {\n  content: \"\\f434\";\n}\n\n.fa-basketball-ball::before {\n  content: \"\\f434\";\n}\n\n.fa-satellite-dish::before {\n  content: \"\\f7c0\";\n}\n\n.fa-circle-up::before {\n  content: \"\\f35b\";\n}\n\n.fa-arrow-alt-circle-up::before {\n  content: \"\\f35b\";\n}\n\n.fa-mobile-screen-button::before {\n  content: \"\\f3cd\";\n}\n\n.fa-mobile-alt::before {\n  content: \"\\f3cd\";\n}\n\n.fa-volume-high::before {\n  content: \"\\f028\";\n}\n\n.fa-volume-up::before {\n  content: \"\\f028\";\n}\n\n.fa-users-rays::before {\n  content: \"\\e593\";\n}\n\n.fa-wallet::before {\n  content: \"\\f555\";\n}\n\n.fa-clipboard-check::before {\n  content: \"\\f46c\";\n}\n\n.fa-file-audio::before {\n  content: \"\\f1c7\";\n}\n\n.fa-burger::before {\n  content: \"\\f805\";\n}\n\n.fa-hamburger::before {\n  content: \"\\f805\";\n}\n\n.fa-wrench::before {\n  content: \"\\f0ad\";\n}\n\n.fa-bugs::before {\n  content: \"\\e4d0\";\n}\n\n.fa-rupee-sign::before {\n  content: \"\\f156\";\n}\n\n.fa-rupee::before {\n  content: \"\\f156\";\n}\n\n.fa-file-image::before {\n  content: \"\\f1c5\";\n}\n\n.fa-circle-question::before {\n  content: \"\\f059\";\n}\n\n.fa-question-circle::before {\n  content: \"\\f059\";\n}\n\n.fa-plane-departure::before {\n  content: \"\\f5b0\";\n}\n\n.fa-handshake-slash::before {\n  content: \"\\e060\";\n}\n\n.fa-book-bookmark::before {\n  content: \"\\e0bb\";\n}\n\n.fa-code-branch::before {\n  content: \"\\f126\";\n}\n\n.fa-hat-cowboy::before {\n  content: \"\\f8c0\";\n}\n\n.fa-bridge::before {\n  content: \"\\e4c8\";\n}\n\n.fa-phone-flip::before {\n  content: \"\\f879\";\n}\n\n.fa-phone-alt::before {\n  content: \"\\f879\";\n}\n\n.fa-truck-front::before {\n  content: \"\\e2b7\";\n}\n\n.fa-cat::before {\n  content: \"\\f6be\";\n}\n\n.fa-anchor-circle-exclamation::before {\n  content: \"\\e4ab\";\n}\n\n.fa-truck-field::before {\n  content: \"\\e58d\";\n}\n\n.fa-route::before {\n  content: \"\\f4d7\";\n}\n\n.fa-clipboard-question::before {\n  content: \"\\e4e3\";\n}\n\n.fa-panorama::before {\n  content: \"\\e209\";\n}\n\n.fa-comment-medical::before {\n  content: \"\\f7f5\";\n}\n\n.fa-teeth-open::before {\n  content: \"\\f62f\";\n}\n\n.fa-file-circle-minus::before {\n  content: \"\\e4ed\";\n}\n\n.fa-tags::before {\n  content: \"\\f02c\";\n}\n\n.fa-wine-glass::before {\n  content: \"\\f4e3\";\n}\n\n.fa-forward-fast::before {\n  content: \"\\f050\";\n}\n\n.fa-fast-forward::before {\n  content: \"\\f050\";\n}\n\n.fa-face-meh-blank::before {\n  content: \"\\f5a4\";\n}\n\n.fa-meh-blank::before {\n  content: \"\\f5a4\";\n}\n\n.fa-square-parking::before {\n  content: \"\\f540\";\n}\n\n.fa-parking::before {\n  content: \"\\f540\";\n}\n\n.fa-house-signal::before {\n  content: \"\\e012\";\n}\n\n.fa-bars-progress::before {\n  content: \"\\f828\";\n}\n\n.fa-tasks-alt::before {\n  content: \"\\f828\";\n}\n\n.fa-faucet-drip::before {\n  content: \"\\e006\";\n}\n\n.fa-cart-flatbed::before {\n  content: \"\\f474\";\n}\n\n.fa-dolly-flatbed::before {\n  content: \"\\f474\";\n}\n\n.fa-ban-smoking::before {\n  content: \"\\f54d\";\n}\n\n.fa-smoking-ban::before {\n  content: \"\\f54d\";\n}\n\n.fa-terminal::before {\n  content: \"\\f120\";\n}\n\n.fa-mobile-button::before {\n  content: \"\\f10b\";\n}\n\n.fa-house-medical-flag::before {\n  content: \"\\e514\";\n}\n\n.fa-basket-shopping::before {\n  content: \"\\f291\";\n}\n\n.fa-shopping-basket::before {\n  content: \"\\f291\";\n}\n\n.fa-tape::before {\n  content: \"\\f4db\";\n}\n\n.fa-bus-simple::before {\n  content: \"\\f55e\";\n}\n\n.fa-bus-alt::before {\n  content: \"\\f55e\";\n}\n\n.fa-eye::before {\n  content: \"\\f06e\";\n}\n\n.fa-face-sad-cry::before {\n  content: \"\\f5b3\";\n}\n\n.fa-sad-cry::before {\n  content: \"\\f5b3\";\n}\n\n.fa-audio-description::before {\n  content: \"\\f29e\";\n}\n\n.fa-person-military-to-person::before {\n  content: \"\\e54c\";\n}\n\n.fa-file-shield::before {\n  content: \"\\e4f0\";\n}\n\n.fa-user-slash::before {\n  content: \"\\f506\";\n}\n\n.fa-pen::before {\n  content: \"\\f304\";\n}\n\n.fa-tower-observation::before {\n  content: \"\\e586\";\n}\n\n.fa-file-code::before {\n  content: \"\\f1c9\";\n}\n\n.fa-signal::before {\n  content: \"\\f012\";\n}\n\n.fa-signal-5::before {\n  content: \"\\f012\";\n}\n\n.fa-signal-perfect::before {\n  content: \"\\f012\";\n}\n\n.fa-bus::before {\n  content: \"\\f207\";\n}\n\n.fa-heart-circle-xmark::before {\n  content: \"\\e501\";\n}\n\n.fa-house-chimney::before {\n  content: \"\\e3af\";\n}\n\n.fa-home-lg::before {\n  content: \"\\e3af\";\n}\n\n.fa-window-maximize::before {\n  content: \"\\f2d0\";\n}\n\n.fa-face-frown::before {\n  content: \"\\f119\";\n}\n\n.fa-frown::before {\n  content: \"\\f119\";\n}\n\n.fa-prescription::before {\n  content: \"\\f5b1\";\n}\n\n.fa-shop::before {\n  content: \"\\f54f\";\n}\n\n.fa-store-alt::before {\n  content: \"\\f54f\";\n}\n\n.fa-floppy-disk::before {\n  content: \"\\f0c7\";\n}\n\n.fa-save::before {\n  content: \"\\f0c7\";\n}\n\n.fa-vihara::before {\n  content: \"\\f6a7\";\n}\n\n.fa-scale-unbalanced::before {\n  content: \"\\f515\";\n}\n\n.fa-balance-scale-left::before {\n  content: \"\\f515\";\n}\n\n.fa-sort-up::before {\n  content: \"\\f0de\";\n}\n\n.fa-sort-asc::before {\n  content: \"\\f0de\";\n}\n\n.fa-comment-dots::before {\n  content: \"\\f4ad\";\n}\n\n.fa-commenting::before {\n  content: \"\\f4ad\";\n}\n\n.fa-plant-wilt::before {\n  content: \"\\e5aa\";\n}\n\n.fa-diamond::before {\n  content: \"\\f219\";\n}\n\n.fa-face-grin-squint::before {\n  content: \"\\f585\";\n}\n\n.fa-grin-squint::before {\n  content: \"\\f585\";\n}\n\n.fa-hand-holding-dollar::before {\n  content: \"\\f4c0\";\n}\n\n.fa-hand-holding-usd::before {\n  content: \"\\f4c0\";\n}\n\n.fa-bacterium::before {\n  content: \"\\e05a\";\n}\n\n.fa-hand-pointer::before {\n  content: \"\\f25a\";\n}\n\n.fa-drum-steelpan::before {\n  content: \"\\f56a\";\n}\n\n.fa-hand-scissors::before {\n  content: \"\\f257\";\n}\n\n.fa-hands-praying::before {\n  content: \"\\f684\";\n}\n\n.fa-praying-hands::before {\n  content: \"\\f684\";\n}\n\n.fa-arrow-rotate-right::before {\n  content: \"\\f01e\";\n}\n\n.fa-arrow-right-rotate::before {\n  content: \"\\f01e\";\n}\n\n.fa-arrow-rotate-forward::before {\n  content: \"\\f01e\";\n}\n\n.fa-redo::before {\n  content: \"\\f01e\";\n}\n\n.fa-biohazard::before {\n  content: \"\\f780\";\n}\n\n.fa-location-crosshairs::before {\n  content: \"\\f601\";\n}\n\n.fa-location::before {\n  content: \"\\f601\";\n}\n\n.fa-mars-double::before {\n  content: \"\\f227\";\n}\n\n.fa-child-dress::before {\n  content: \"\\e59c\";\n}\n\n.fa-users-between-lines::before {\n  content: \"\\e591\";\n}\n\n.fa-lungs-virus::before {\n  content: \"\\e067\";\n}\n\n.fa-face-grin-tears::before {\n  content: \"\\f588\";\n}\n\n.fa-grin-tears::before {\n  content: \"\\f588\";\n}\n\n.fa-phone::before {\n  content: \"\\f095\";\n}\n\n.fa-calendar-xmark::before {\n  content: \"\\f273\";\n}\n\n.fa-calendar-times::before {\n  content: \"\\f273\";\n}\n\n.fa-child-reaching::before {\n  content: \"\\e59d\";\n}\n\n.fa-head-side-virus::before {\n  content: \"\\e064\";\n}\n\n.fa-user-gear::before {\n  content: \"\\f4fe\";\n}\n\n.fa-user-cog::before {\n  content: \"\\f4fe\";\n}\n\n.fa-arrow-up-1-9::before {\n  content: \"\\f163\";\n}\n\n.fa-sort-numeric-up::before {\n  content: \"\\f163\";\n}\n\n.fa-door-closed::before {\n  content: \"\\f52a\";\n}\n\n.fa-shield-virus::before {\n  content: \"\\e06c\";\n}\n\n.fa-dice-six::before {\n  content: \"\\f526\";\n}\n\n.fa-mosquito-net::before {\n  content: \"\\e52c\";\n}\n\n.fa-bridge-water::before {\n  content: \"\\e4ce\";\n}\n\n.fa-person-booth::before {\n  content: \"\\f756\";\n}\n\n.fa-text-width::before {\n  content: \"\\f035\";\n}\n\n.fa-hat-wizard::before {\n  content: \"\\f6e8\";\n}\n\n.fa-pen-fancy::before {\n  content: \"\\f5ac\";\n}\n\n.fa-person-digging::before {\n  content: \"\\f85e\";\n}\n\n.fa-digging::before {\n  content: \"\\f85e\";\n}\n\n.fa-trash::before {\n  content: \"\\f1f8\";\n}\n\n.fa-gauge-simple::before {\n  content: \"\\f629\";\n}\n\n.fa-gauge-simple-med::before {\n  content: \"\\f629\";\n}\n\n.fa-tachometer-average::before {\n  content: \"\\f629\";\n}\n\n.fa-book-medical::before {\n  content: \"\\f7e6\";\n}\n\n.fa-poo::before {\n  content: \"\\f2fe\";\n}\n\n.fa-quote-right::before {\n  content: \"\\f10e\";\n}\n\n.fa-quote-right-alt::before {\n  content: \"\\f10e\";\n}\n\n.fa-shirt::before {\n  content: \"\\f553\";\n}\n\n.fa-t-shirt::before {\n  content: \"\\f553\";\n}\n\n.fa-tshirt::before {\n  content: \"\\f553\";\n}\n\n.fa-cubes::before {\n  content: \"\\f1b3\";\n}\n\n.fa-divide::before {\n  content: \"\\f529\";\n}\n\n.fa-tenge-sign::before {\n  content: \"\\f7d7\";\n}\n\n.fa-tenge::before {\n  content: \"\\f7d7\";\n}\n\n.fa-headphones::before {\n  content: \"\\f025\";\n}\n\n.fa-hands-holding::before {\n  content: \"\\f4c2\";\n}\n\n.fa-hands-clapping::before {\n  content: \"\\e1a8\";\n}\n\n.fa-republican::before {\n  content: \"\\f75e\";\n}\n\n.fa-arrow-left::before {\n  content: \"\\f060\";\n}\n\n.fa-person-circle-xmark::before {\n  content: \"\\e543\";\n}\n\n.fa-ruler::before {\n  content: \"\\f545\";\n}\n\n.fa-align-left::before {\n  content: \"\\f036\";\n}\n\n.fa-dice-d6::before {\n  content: \"\\f6d1\";\n}\n\n.fa-restroom::before {\n  content: \"\\f7bd\";\n}\n\n.fa-j::before {\n  content: \"J\";\n}\n\n.fa-users-viewfinder::before {\n  content: \"\\e595\";\n}\n\n.fa-file-video::before {\n  content: \"\\f1c8\";\n}\n\n.fa-up-right-from-square::before {\n  content: \"\\f35d\";\n}\n\n.fa-external-link-alt::before {\n  content: \"\\f35d\";\n}\n\n.fa-table-cells::before {\n  content: \"\\f00a\";\n}\n\n.fa-th::before {\n  content: \"\\f00a\";\n}\n\n.fa-file-pdf::before {\n  content: \"\\f1c1\";\n}\n\n.fa-book-bible::before {\n  content: \"\\f647\";\n}\n\n.fa-bible::before {\n  content: \"\\f647\";\n}\n\n.fa-o::before {\n  content: \"O\";\n}\n\n.fa-suitcase-medical::before {\n  content: \"\\f0fa\";\n}\n\n.fa-medkit::before {\n  content: \"\\f0fa\";\n}\n\n.fa-user-secret::before {\n  content: \"\\f21b\";\n}\n\n.fa-otter::before {\n  content: \"\\f700\";\n}\n\n.fa-person-dress::before {\n  content: \"\\f182\";\n}\n\n.fa-female::before {\n  content: \"\\f182\";\n}\n\n.fa-comment-dollar::before {\n  content: \"\\f651\";\n}\n\n.fa-business-time::before {\n  content: \"\\f64a\";\n}\n\n.fa-briefcase-clock::before {\n  content: \"\\f64a\";\n}\n\n.fa-table-cells-large::before {\n  content: \"\\f009\";\n}\n\n.fa-th-large::before {\n  content: \"\\f009\";\n}\n\n.fa-book-tanakh::before {\n  content: \"\\f827\";\n}\n\n.fa-tanakh::before {\n  content: \"\\f827\";\n}\n\n.fa-phone-volume::before {\n  content: \"\\f2a0\";\n}\n\n.fa-volume-control-phone::before {\n  content: \"\\f2a0\";\n}\n\n.fa-hat-cowboy-side::before {\n  content: \"\\f8c1\";\n}\n\n.fa-clipboard-user::before {\n  content: \"\\f7f3\";\n}\n\n.fa-child::before {\n  content: \"\\f1ae\";\n}\n\n.fa-lira-sign::before {\n  content: \"\\f195\";\n}\n\n.fa-satellite::before {\n  content: \"\\f7bf\";\n}\n\n.fa-plane-lock::before {\n  content: \"\\e558\";\n}\n\n.fa-tag::before {\n  content: \"\\f02b\";\n}\n\n.fa-comment::before {\n  content: \"\\f075\";\n}\n\n.fa-cake-candles::before {\n  content: \"\\f1fd\";\n}\n\n.fa-birthday-cake::before {\n  content: \"\\f1fd\";\n}\n\n.fa-cake::before {\n  content: \"\\f1fd\";\n}\n\n.fa-envelope::before {\n  content: \"\\f0e0\";\n}\n\n.fa-angles-up::before {\n  content: \"\\f102\";\n}\n\n.fa-angle-double-up::before {\n  content: \"\\f102\";\n}\n\n.fa-paperclip::before {\n  content: \"\\f0c6\";\n}\n\n.fa-arrow-right-to-city::before {\n  content: \"\\e4b3\";\n}\n\n.fa-ribbon::before {\n  content: \"\\f4d6\";\n}\n\n.fa-lungs::before {\n  content: \"\\f604\";\n}\n\n.fa-arrow-up-9-1::before {\n  content: \"\\f887\";\n}\n\n.fa-sort-numeric-up-alt::before {\n  content: \"\\f887\";\n}\n\n.fa-litecoin-sign::before {\n  content: \"\\e1d3\";\n}\n\n.fa-border-none::before {\n  content: \"\\f850\";\n}\n\n.fa-circle-nodes::before {\n  content: \"\\e4e2\";\n}\n\n.fa-parachute-box::before {\n  content: \"\\f4cd\";\n}\n\n.fa-indent::before {\n  content: \"\\f03c\";\n}\n\n.fa-truck-field-un::before {\n  content: \"\\e58e\";\n}\n\n.fa-hourglass::before {\n  content: \"\\f254\";\n}\n\n.fa-hourglass-empty::before {\n  content: \"\\f254\";\n}\n\n.fa-mountain::before {\n  content: \"\\f6fc\";\n}\n\n.fa-user-doctor::before {\n  content: \"\\f0f0\";\n}\n\n.fa-user-md::before {\n  content: \"\\f0f0\";\n}\n\n.fa-circle-info::before {\n  content: \"\\f05a\";\n}\n\n.fa-info-circle::before {\n  content: \"\\f05a\";\n}\n\n.fa-cloud-meatball::before {\n  content: \"\\f73b\";\n}\n\n.fa-camera::before {\n  content: \"\\f030\";\n}\n\n.fa-camera-alt::before {\n  content: \"\\f030\";\n}\n\n.fa-square-virus::before {\n  content: \"\\e578\";\n}\n\n.fa-meteor::before {\n  content: \"\\f753\";\n}\n\n.fa-car-on::before {\n  content: \"\\e4dd\";\n}\n\n.fa-sleigh::before {\n  content: \"\\f7cc\";\n}\n\n.fa-arrow-down-1-9::before {\n  content: \"\\f162\";\n}\n\n.fa-sort-numeric-asc::before {\n  content: \"\\f162\";\n}\n\n.fa-sort-numeric-down::before {\n  content: \"\\f162\";\n}\n\n.fa-hand-holding-droplet::before {\n  content: \"\\f4c1\";\n}\n\n.fa-hand-holding-water::before {\n  content: \"\\f4c1\";\n}\n\n.fa-water::before {\n  content: \"\\f773\";\n}\n\n.fa-calendar-check::before {\n  content: \"\\f274\";\n}\n\n.fa-braille::before {\n  content: \"\\f2a1\";\n}\n\n.fa-prescription-bottle-medical::before {\n  content: \"\\f486\";\n}\n\n.fa-prescription-bottle-alt::before {\n  content: \"\\f486\";\n}\n\n.fa-landmark::before {\n  content: \"\\f66f\";\n}\n\n.fa-truck::before {\n  content: \"\\f0d1\";\n}\n\n.fa-crosshairs::before {\n  content: \"\\f05b\";\n}\n\n.fa-person-cane::before {\n  content: \"\\e53c\";\n}\n\n.fa-tent::before {\n  content: \"\\e57d\";\n}\n\n.fa-vest-patches::before {\n  content: \"\\e086\";\n}\n\n.fa-check-double::before {\n  content: \"\\f560\";\n}\n\n.fa-arrow-down-a-z::before {\n  content: \"\\f15d\";\n}\n\n.fa-sort-alpha-asc::before {\n  content: \"\\f15d\";\n}\n\n.fa-sort-alpha-down::before {\n  content: \"\\f15d\";\n}\n\n.fa-money-bill-wheat::before {\n  content: \"\\e52a\";\n}\n\n.fa-cookie::before {\n  content: \"\\f563\";\n}\n\n.fa-arrow-rotate-left::before {\n  content: \"\\f0e2\";\n}\n\n.fa-arrow-left-rotate::before {\n  content: \"\\f0e2\";\n}\n\n.fa-arrow-rotate-back::before {\n  content: \"\\f0e2\";\n}\n\n.fa-arrow-rotate-backward::before {\n  content: \"\\f0e2\";\n}\n\n.fa-undo::before {\n  content: \"\\f0e2\";\n}\n\n.fa-hard-drive::before {\n  content: \"\\f0a0\";\n}\n\n.fa-hdd::before {\n  content: \"\\f0a0\";\n}\n\n.fa-face-grin-squint-tears::before {\n  content: \"\\f586\";\n}\n\n.fa-grin-squint-tears::before {\n  content: \"\\f586\";\n}\n\n.fa-dumbbell::before {\n  content: \"\\f44b\";\n}\n\n.fa-rectangle-list::before {\n  content: \"\\f022\";\n}\n\n.fa-list-alt::before {\n  content: \"\\f022\";\n}\n\n.fa-tarp-droplet::before {\n  content: \"\\e57c\";\n}\n\n.fa-house-medical-circle-check::before {\n  content: \"\\e511\";\n}\n\n.fa-person-skiing-nordic::before {\n  content: \"\\f7ca\";\n}\n\n.fa-skiing-nordic::before {\n  content: \"\\f7ca\";\n}\n\n.fa-calendar-plus::before {\n  content: \"\\f271\";\n}\n\n.fa-plane-arrival::before {\n  content: \"\\f5af\";\n}\n\n.fa-circle-left::before {\n  content: \"\\f359\";\n}\n\n.fa-arrow-alt-circle-left::before {\n  content: \"\\f359\";\n}\n\n.fa-train-subway::before {\n  content: \"\\f239\";\n}\n\n.fa-subway::before {\n  content: \"\\f239\";\n}\n\n.fa-chart-gantt::before {\n  content: \"\\e0e4\";\n}\n\n.fa-indian-rupee-sign::before {\n  content: \"\\e1bc\";\n}\n\n.fa-indian-rupee::before {\n  content: \"\\e1bc\";\n}\n\n.fa-inr::before {\n  content: \"\\e1bc\";\n}\n\n.fa-crop-simple::before {\n  content: \"\\f565\";\n}\n\n.fa-crop-alt::before {\n  content: \"\\f565\";\n}\n\n.fa-money-bill-1::before {\n  content: \"\\f3d1\";\n}\n\n.fa-money-bill-alt::before {\n  content: \"\\f3d1\";\n}\n\n.fa-left-long::before {\n  content: \"\\f30a\";\n}\n\n.fa-long-arrow-alt-left::before {\n  content: \"\\f30a\";\n}\n\n.fa-dna::before {\n  content: \"\\f471\";\n}\n\n.fa-virus-slash::before {\n  content: \"\\e075\";\n}\n\n.fa-minus::before {\n  content: \"\\f068\";\n}\n\n.fa-subtract::before {\n  content: \"\\f068\";\n}\n\n.fa-child-rifle::before {\n  content: \"\\e4e0\";\n}\n\n.fa-chess::before {\n  content: \"\\f439\";\n}\n\n.fa-arrow-left-long::before {\n  content: \"\\f177\";\n}\n\n.fa-long-arrow-left::before {\n  content: \"\\f177\";\n}\n\n.fa-plug-circle-check::before {\n  content: \"\\e55c\";\n}\n\n.fa-street-view::before {\n  content: \"\\f21d\";\n}\n\n.fa-franc-sign::before {\n  content: \"\\e18f\";\n}\n\n.fa-volume-off::before {\n  content: \"\\f026\";\n}\n\n.fa-hands-asl-interpreting::before {\n  content: \"\\f2a3\";\n}\n\n.fa-american-sign-language-interpreting::before {\n  content: \"\\f2a3\";\n}\n\n.fa-asl-interpreting::before {\n  content: \"\\f2a3\";\n}\n\n.fa-hands-american-sign-language-interpreting::before {\n  content: \"\\f2a3\";\n}\n\n.fa-gear::before {\n  content: \"\\f013\";\n}\n\n.fa-cog::before {\n  content: \"\\f013\";\n}\n\n.fa-droplet-slash::before {\n  content: \"\\f5c7\";\n}\n\n.fa-tint-slash::before {\n  content: \"\\f5c7\";\n}\n\n.fa-mosque::before {\n  content: \"\\f678\";\n}\n\n.fa-mosquito::before {\n  content: \"\\e52b\";\n}\n\n.fa-star-of-david::before {\n  content: \"\\f69a\";\n}\n\n.fa-person-military-rifle::before {\n  content: \"\\e54b\";\n}\n\n.fa-cart-shopping::before {\n  content: \"\\f07a\";\n}\n\n.fa-shopping-cart::before {\n  content: \"\\f07a\";\n}\n\n.fa-vials::before {\n  content: \"\\f493\";\n}\n\n.fa-plug-circle-plus::before {\n  content: \"\\e55f\";\n}\n\n.fa-place-of-worship::before {\n  content: \"\\f67f\";\n}\n\n.fa-grip-vertical::before {\n  content: \"\\f58e\";\n}\n\n.fa-arrow-turn-up::before {\n  content: \"\\f148\";\n}\n\n.fa-level-up::before {\n  content: \"\\f148\";\n}\n\n.fa-u::before {\n  content: \"U\";\n}\n\n.fa-square-root-variable::before {\n  content: \"\\f698\";\n}\n\n.fa-square-root-alt::before {\n  content: \"\\f698\";\n}\n\n.fa-clock::before {\n  content: \"\\f017\";\n}\n\n.fa-clock-four::before {\n  content: \"\\f017\";\n}\n\n.fa-backward-step::before {\n  content: \"\\f048\";\n}\n\n.fa-step-backward::before {\n  content: \"\\f048\";\n}\n\n.fa-pallet::before {\n  content: \"\\f482\";\n}\n\n.fa-faucet::before {\n  content: \"\\e005\";\n}\n\n.fa-baseball-bat-ball::before {\n  content: \"\\f432\";\n}\n\n.fa-s::before {\n  content: \"S\";\n}\n\n.fa-timeline::before {\n  content: \"\\e29c\";\n}\n\n.fa-keyboard::before {\n  content: \"\\f11c\";\n}\n\n.fa-caret-down::before {\n  content: \"\\f0d7\";\n}\n\n.fa-house-chimney-medical::before {\n  content: \"\\f7f2\";\n}\n\n.fa-clinic-medical::before {\n  content: \"\\f7f2\";\n}\n\n.fa-temperature-three-quarters::before {\n  content: \"\\f2c8\";\n}\n\n.fa-temperature-3::before {\n  content: \"\\f2c8\";\n}\n\n.fa-thermometer-3::before {\n  content: \"\\f2c8\";\n}\n\n.fa-thermometer-three-quarters::before {\n  content: \"\\f2c8\";\n}\n\n.fa-mobile-screen::before {\n  content: \"\\f3cf\";\n}\n\n.fa-mobile-android-alt::before {\n  content: \"\\f3cf\";\n}\n\n.fa-plane-up::before {\n  content: \"\\e22d\";\n}\n\n.fa-piggy-bank::before {\n  content: \"\\f4d3\";\n}\n\n.fa-battery-half::before {\n  content: \"\\f242\";\n}\n\n.fa-battery-3::before {\n  content: \"\\f242\";\n}\n\n.fa-mountain-city::before {\n  content: \"\\e52e\";\n}\n\n.fa-coins::before {\n  content: \"\\f51e\";\n}\n\n.fa-khanda::before {\n  content: \"\\f66d\";\n}\n\n.fa-sliders::before {\n  content: \"\\f1de\";\n}\n\n.fa-sliders-h::before {\n  content: \"\\f1de\";\n}\n\n.fa-folder-tree::before {\n  content: \"\\f802\";\n}\n\n.fa-network-wired::before {\n  content: \"\\f6ff\";\n}\n\n.fa-map-pin::before {\n  content: \"\\f276\";\n}\n\n.fa-hamsa::before {\n  content: \"\\f665\";\n}\n\n.fa-cent-sign::before {\n  content: \"\\e3f5\";\n}\n\n.fa-flask::before {\n  content: \"\\f0c3\";\n}\n\n.fa-person-pregnant::before {\n  content: \"\\e31e\";\n}\n\n.fa-wand-sparkles::before {\n  content: \"\\f72b\";\n}\n\n.fa-ellipsis-vertical::before {\n  content: \"\\f142\";\n}\n\n.fa-ellipsis-v::before {\n  content: \"\\f142\";\n}\n\n.fa-ticket::before {\n  content: \"\\f145\";\n}\n\n.fa-power-off::before {\n  content: \"\\f011\";\n}\n\n.fa-right-long::before {\n  content: \"\\f30b\";\n}\n\n.fa-long-arrow-alt-right::before {\n  content: \"\\f30b\";\n}\n\n.fa-flag-usa::before {\n  content: \"\\f74d\";\n}\n\n.fa-laptop-file::before {\n  content: \"\\e51d\";\n}\n\n.fa-tty::before {\n  content: \"\\f1e4\";\n}\n\n.fa-teletype::before {\n  content: \"\\f1e4\";\n}\n\n.fa-diagram-next::before {\n  content: \"\\e476\";\n}\n\n.fa-person-rifle::before {\n  content: \"\\e54e\";\n}\n\n.fa-house-medical-circle-exclamation::before {\n  content: \"\\e512\";\n}\n\n.fa-closed-captioning::before {\n  content: \"\\f20a\";\n}\n\n.fa-person-hiking::before {\n  content: \"\\f6ec\";\n}\n\n.fa-hiking::before {\n  content: \"\\f6ec\";\n}\n\n.fa-venus-double::before {\n  content: \"\\f226\";\n}\n\n.fa-images::before {\n  content: \"\\f302\";\n}\n\n.fa-calculator::before {\n  content: \"\\f1ec\";\n}\n\n.fa-people-pulling::before {\n  content: \"\\e535\";\n}\n\n.fa-n::before {\n  content: \"N\";\n}\n\n.fa-cable-car::before {\n  content: \"\\f7da\";\n}\n\n.fa-tram::before {\n  content: \"\\f7da\";\n}\n\n.fa-cloud-rain::before {\n  content: \"\\f73d\";\n}\n\n.fa-building-circle-xmark::before {\n  content: \"\\e4d4\";\n}\n\n.fa-ship::before {\n  content: \"\\f21a\";\n}\n\n.fa-arrows-down-to-line::before {\n  content: \"\\e4b8\";\n}\n\n.fa-download::before {\n  content: \"\\f019\";\n}\n\n.fa-face-grin::before {\n  content: \"\\f580\";\n}\n\n.fa-grin::before {\n  content: \"\\f580\";\n}\n\n.fa-delete-left::before {\n  content: \"\\f55a\";\n}\n\n.fa-backspace::before {\n  content: \"\\f55a\";\n}\n\n.fa-eye-dropper::before {\n  content: \"\\f1fb\";\n}\n\n.fa-eye-dropper-empty::before {\n  content: \"\\f1fb\";\n}\n\n.fa-eyedropper::before {\n  content: \"\\f1fb\";\n}\n\n.fa-file-circle-check::before {\n  content: \"\\e5a0\";\n}\n\n.fa-forward::before {\n  content: \"\\f04e\";\n}\n\n.fa-mobile::before {\n  content: \"\\f3ce\";\n}\n\n.fa-mobile-android::before {\n  content: \"\\f3ce\";\n}\n\n.fa-mobile-phone::before {\n  content: \"\\f3ce\";\n}\n\n.fa-face-meh::before {\n  content: \"\\f11a\";\n}\n\n.fa-meh::before {\n  content: \"\\f11a\";\n}\n\n.fa-align-center::before {\n  content: \"\\f037\";\n}\n\n.fa-book-skull::before {\n  content: \"\\f6b7\";\n}\n\n.fa-book-dead::before {\n  content: \"\\f6b7\";\n}\n\n.fa-id-card::before {\n  content: \"\\f2c2\";\n}\n\n.fa-drivers-license::before {\n  content: \"\\f2c2\";\n}\n\n.fa-outdent::before {\n  content: \"\\f03b\";\n}\n\n.fa-dedent::before {\n  content: \"\\f03b\";\n}\n\n.fa-heart-circle-exclamation::before {\n  content: \"\\e4fe\";\n}\n\n.fa-house::before {\n  content: \"\\f015\";\n}\n\n.fa-home::before {\n  content: \"\\f015\";\n}\n\n.fa-home-alt::before {\n  content: \"\\f015\";\n}\n\n.fa-home-lg-alt::before {\n  content: \"\\f015\";\n}\n\n.fa-calendar-week::before {\n  content: \"\\f784\";\n}\n\n.fa-laptop-medical::before {\n  content: \"\\f812\";\n}\n\n.fa-b::before {\n  content: \"B\";\n}\n\n.fa-file-medical::before {\n  content: \"\\f477\";\n}\n\n.fa-dice-one::before {\n  content: \"\\f525\";\n}\n\n.fa-kiwi-bird::before {\n  content: \"\\f535\";\n}\n\n.fa-arrow-right-arrow-left::before {\n  content: \"\\f0ec\";\n}\n\n.fa-exchange::before {\n  content: \"\\f0ec\";\n}\n\n.fa-rotate-right::before {\n  content: \"\\f2f9\";\n}\n\n.fa-redo-alt::before {\n  content: \"\\f2f9\";\n}\n\n.fa-rotate-forward::before {\n  content: \"\\f2f9\";\n}\n\n.fa-utensils::before {\n  content: \"\\f2e7\";\n}\n\n.fa-cutlery::before {\n  content: \"\\f2e7\";\n}\n\n.fa-arrow-up-wide-short::before {\n  content: \"\\f161\";\n}\n\n.fa-sort-amount-up::before {\n  content: \"\\f161\";\n}\n\n.fa-mill-sign::before {\n  content: \"\\e1ed\";\n}\n\n.fa-bowl-rice::before {\n  content: \"\\e2eb\";\n}\n\n.fa-skull::before {\n  content: \"\\f54c\";\n}\n\n.fa-tower-broadcast::before {\n  content: \"\\f519\";\n}\n\n.fa-broadcast-tower::before {\n  content: \"\\f519\";\n}\n\n.fa-truck-pickup::before {\n  content: \"\\f63c\";\n}\n\n.fa-up-long::before {\n  content: \"\\f30c\";\n}\n\n.fa-long-arrow-alt-up::before {\n  content: \"\\f30c\";\n}\n\n.fa-stop::before {\n  content: \"\\f04d\";\n}\n\n.fa-code-merge::before {\n  content: \"\\f387\";\n}\n\n.fa-upload::before {\n  content: \"\\f093\";\n}\n\n.fa-hurricane::before {\n  content: \"\\f751\";\n}\n\n.fa-mound::before {\n  content: \"\\e52d\";\n}\n\n.fa-toilet-portable::before {\n  content: \"\\e583\";\n}\n\n.fa-compact-disc::before {\n  content: \"\\f51f\";\n}\n\n.fa-file-arrow-down::before {\n  content: \"\\f56d\";\n}\n\n.fa-file-download::before {\n  content: \"\\f56d\";\n}\n\n.fa-caravan::before {\n  content: \"\\f8ff\";\n}\n\n.fa-shield-cat::before {\n  content: \"\\e572\";\n}\n\n.fa-bolt::before {\n  content: \"\\f0e7\";\n}\n\n.fa-zap::before {\n  content: \"\\f0e7\";\n}\n\n.fa-glass-water::before {\n  content: \"\\e4f4\";\n}\n\n.fa-oil-well::before {\n  content: \"\\e532\";\n}\n\n.fa-vault::before {\n  content: \"\\e2c5\";\n}\n\n.fa-mars::before {\n  content: \"\\f222\";\n}\n\n.fa-toilet::before {\n  content: \"\\f7d8\";\n}\n\n.fa-plane-circle-xmark::before {\n  content: \"\\e557\";\n}\n\n.fa-yen-sign::before {\n  content: \"\\f157\";\n}\n\n.fa-cny::before {\n  content: \"\\f157\";\n}\n\n.fa-jpy::before {\n  content: \"\\f157\";\n}\n\n.fa-rmb::before {\n  content: \"\\f157\";\n}\n\n.fa-yen::before {\n  content: \"\\f157\";\n}\n\n.fa-ruble-sign::before {\n  content: \"\\f158\";\n}\n\n.fa-rouble::before {\n  content: \"\\f158\";\n}\n\n.fa-rub::before {\n  content: \"\\f158\";\n}\n\n.fa-ruble::before {\n  content: \"\\f158\";\n}\n\n.fa-sun::before {\n  content: \"\\f185\";\n}\n\n.fa-guitar::before {\n  content: \"\\f7a6\";\n}\n\n.fa-face-laugh-wink::before {\n  content: \"\\f59c\";\n}\n\n.fa-laugh-wink::before {\n  content: \"\\f59c\";\n}\n\n.fa-horse-head::before {\n  content: \"\\f7ab\";\n}\n\n.fa-bore-hole::before {\n  content: \"\\e4c3\";\n}\n\n.fa-industry::before {\n  content: \"\\f275\";\n}\n\n.fa-circle-down::before {\n  content: \"\\f358\";\n}\n\n.fa-arrow-alt-circle-down::before {\n  content: \"\\f358\";\n}\n\n.fa-arrows-turn-to-dots::before {\n  content: \"\\e4c1\";\n}\n\n.fa-florin-sign::before {\n  content: \"\\e184\";\n}\n\n.fa-arrow-down-short-wide::before {\n  content: \"\\f884\";\n}\n\n.fa-sort-amount-desc::before {\n  content: \"\\f884\";\n}\n\n.fa-sort-amount-down-alt::before {\n  content: \"\\f884\";\n}\n\n.fa-less-than::before {\n  content: \"\\<\";\n}\n\n.fa-angle-down::before {\n  content: \"\\f107\";\n}\n\n.fa-car-tunnel::before {\n  content: \"\\e4de\";\n}\n\n.fa-head-side-cough::before {\n  content: \"\\e061\";\n}\n\n.fa-grip-lines::before {\n  content: \"\\f7a4\";\n}\n\n.fa-thumbs-down::before {\n  content: \"\\f165\";\n}\n\n.fa-user-lock::before {\n  content: \"\\f502\";\n}\n\n.fa-arrow-right-long::before {\n  content: \"\\f178\";\n}\n\n.fa-long-arrow-right::before {\n  content: \"\\f178\";\n}\n\n.fa-anchor-circle-xmark::before {\n  content: \"\\e4ac\";\n}\n\n.fa-ellipsis::before {\n  content: \"\\f141\";\n}\n\n.fa-ellipsis-h::before {\n  content: \"\\f141\";\n}\n\n.fa-chess-pawn::before {\n  content: \"\\f443\";\n}\n\n.fa-kit-medical::before {\n  content: \"\\f479\";\n}\n\n.fa-first-aid::before {\n  content: \"\\f479\";\n}\n\n.fa-person-through-window::before {\n  content: \"\\e5a9\";\n}\n\n.fa-toolbox::before {\n  content: \"\\f552\";\n}\n\n.fa-hands-holding-circle::before {\n  content: \"\\e4fb\";\n}\n\n.fa-bug::before {\n  content: \"\\f188\";\n}\n\n.fa-credit-card::before {\n  content: \"\\f09d\";\n}\n\n.fa-credit-card-alt::before {\n  content: \"\\f09d\";\n}\n\n.fa-car::before {\n  content: \"\\f1b9\";\n}\n\n.fa-automobile::before {\n  content: \"\\f1b9\";\n}\n\n.fa-hand-holding-hand::before {\n  content: \"\\e4f7\";\n}\n\n.fa-book-open-reader::before {\n  content: \"\\f5da\";\n}\n\n.fa-book-reader::before {\n  content: \"\\f5da\";\n}\n\n.fa-mountain-sun::before {\n  content: \"\\e52f\";\n}\n\n.fa-arrows-left-right-to-line::before {\n  content: \"\\e4ba\";\n}\n\n.fa-dice-d20::before {\n  content: \"\\f6cf\";\n}\n\n.fa-truck-droplet::before {\n  content: \"\\e58c\";\n}\n\n.fa-file-circle-xmark::before {\n  content: \"\\e5a1\";\n}\n\n.fa-temperature-arrow-up::before {\n  content: \"\\e040\";\n}\n\n.fa-temperature-up::before {\n  content: \"\\e040\";\n}\n\n.fa-medal::before {\n  content: \"\\f5a2\";\n}\n\n.fa-bed::before {\n  content: \"\\f236\";\n}\n\n.fa-square-h::before {\n  content: \"\\f0fd\";\n}\n\n.fa-h-square::before {\n  content: \"\\f0fd\";\n}\n\n.fa-podcast::before {\n  content: \"\\f2ce\";\n}\n\n.fa-temperature-full::before {\n  content: \"\\f2c7\";\n}\n\n.fa-temperature-4::before {\n  content: \"\\f2c7\";\n}\n\n.fa-thermometer-4::before {\n  content: \"\\f2c7\";\n}\n\n.fa-thermometer-full::before {\n  content: \"\\f2c7\";\n}\n\n.fa-bell::before {\n  content: \"\\f0f3\";\n}\n\n.fa-superscript::before {\n  content: \"\\f12b\";\n}\n\n.fa-plug-circle-xmark::before {\n  content: \"\\e560\";\n}\n\n.fa-star-of-life::before {\n  content: \"\\f621\";\n}\n\n.fa-phone-slash::before {\n  content: \"\\f3dd\";\n}\n\n.fa-paint-roller::before {\n  content: \"\\f5aa\";\n}\n\n.fa-handshake-angle::before {\n  content: \"\\f4c4\";\n}\n\n.fa-hands-helping::before {\n  content: \"\\f4c4\";\n}\n\n.fa-location-dot::before {\n  content: \"\\f3c5\";\n}\n\n.fa-map-marker-alt::before {\n  content: \"\\f3c5\";\n}\n\n.fa-file::before {\n  content: \"\\f15b\";\n}\n\n.fa-greater-than::before {\n  content: \"\\>\";\n}\n\n.fa-person-swimming::before {\n  content: \"\\f5c4\";\n}\n\n.fa-swimmer::before {\n  content: \"\\f5c4\";\n}\n\n.fa-arrow-down::before {\n  content: \"\\f063\";\n}\n\n.fa-droplet::before {\n  content: \"\\f043\";\n}\n\n.fa-tint::before {\n  content: \"\\f043\";\n}\n\n.fa-eraser::before {\n  content: \"\\f12d\";\n}\n\n.fa-earth-americas::before {\n  content: \"\\f57d\";\n}\n\n.fa-earth::before {\n  content: \"\\f57d\";\n}\n\n.fa-earth-america::before {\n  content: \"\\f57d\";\n}\n\n.fa-globe-americas::before {\n  content: \"\\f57d\";\n}\n\n.fa-person-burst::before {\n  content: \"\\e53b\";\n}\n\n.fa-dove::before {\n  content: \"\\f4ba\";\n}\n\n.fa-battery-empty::before {\n  content: \"\\f244\";\n}\n\n.fa-battery-0::before {\n  content: \"\\f244\";\n}\n\n.fa-socks::before {\n  content: \"\\f696\";\n}\n\n.fa-inbox::before {\n  content: \"\\f01c\";\n}\n\n.fa-section::before {\n  content: \"\\e447\";\n}\n\n.fa-gauge-high::before {\n  content: \"\\f625\";\n}\n\n.fa-tachometer-alt::before {\n  content: \"\\f625\";\n}\n\n.fa-tachometer-alt-fast::before {\n  content: \"\\f625\";\n}\n\n.fa-envelope-open-text::before {\n  content: \"\\f658\";\n}\n\n.fa-hospital::before {\n  content: \"\\f0f8\";\n}\n\n.fa-hospital-alt::before {\n  content: \"\\f0f8\";\n}\n\n.fa-hospital-wide::before {\n  content: \"\\f0f8\";\n}\n\n.fa-wine-bottle::before {\n  content: \"\\f72f\";\n}\n\n.fa-chess-rook::before {\n  content: \"\\f447\";\n}\n\n.fa-bars-staggered::before {\n  content: \"\\f550\";\n}\n\n.fa-reorder::before {\n  content: \"\\f550\";\n}\n\n.fa-stream::before {\n  content: \"\\f550\";\n}\n\n.fa-dharmachakra::before {\n  content: \"\\f655\";\n}\n\n.fa-hotdog::before {\n  content: \"\\f80f\";\n}\n\n.fa-person-walking-with-cane::before {\n  content: \"\\f29d\";\n}\n\n.fa-blind::before {\n  content: \"\\f29d\";\n}\n\n.fa-drum::before {\n  content: \"\\f569\";\n}\n\n.fa-ice-cream::before {\n  content: \"\\f810\";\n}\n\n.fa-heart-circle-bolt::before {\n  content: \"\\e4fc\";\n}\n\n.fa-fax::before {\n  content: \"\\f1ac\";\n}\n\n.fa-paragraph::before {\n  content: \"\\f1dd\";\n}\n\n.fa-check-to-slot::before {\n  content: \"\\f772\";\n}\n\n.fa-vote-yea::before {\n  content: \"\\f772\";\n}\n\n.fa-star-half::before {\n  content: \"\\f089\";\n}\n\n.fa-boxes-stacked::before {\n  content: \"\\f468\";\n}\n\n.fa-boxes::before {\n  content: \"\\f468\";\n}\n\n.fa-boxes-alt::before {\n  content: \"\\f468\";\n}\n\n.fa-link::before {\n  content: \"\\f0c1\";\n}\n\n.fa-chain::before {\n  content: \"\\f0c1\";\n}\n\n.fa-ear-listen::before {\n  content: \"\\f2a2\";\n}\n\n.fa-assistive-listening-systems::before {\n  content: \"\\f2a2\";\n}\n\n.fa-tree-city::before {\n  content: \"\\e587\";\n}\n\n.fa-play::before {\n  content: \"\\f04b\";\n}\n\n.fa-font::before {\n  content: \"\\f031\";\n}\n\n.fa-rupiah-sign::before {\n  content: \"\\e23d\";\n}\n\n.fa-magnifying-glass::before {\n  content: \"\\f002\";\n}\n\n.fa-search::before {\n  content: \"\\f002\";\n}\n\n.fa-table-tennis-paddle-ball::before {\n  content: \"\\f45d\";\n}\n\n.fa-ping-pong-paddle-ball::before {\n  content: \"\\f45d\";\n}\n\n.fa-table-tennis::before {\n  content: \"\\f45d\";\n}\n\n.fa-person-dots-from-line::before {\n  content: \"\\f470\";\n}\n\n.fa-diagnoses::before {\n  content: \"\\f470\";\n}\n\n.fa-trash-can-arrow-up::before {\n  content: \"\\f82a\";\n}\n\n.fa-trash-restore-alt::before {\n  content: \"\\f82a\";\n}\n\n.fa-naira-sign::before {\n  content: \"\\e1f6\";\n}\n\n.fa-cart-arrow-down::before {\n  content: \"\\f218\";\n}\n\n.fa-walkie-talkie::before {\n  content: \"\\f8ef\";\n}\n\n.fa-file-pen::before {\n  content: \"\\f31c\";\n}\n\n.fa-file-edit::before {\n  content: \"\\f31c\";\n}\n\n.fa-receipt::before {\n  content: \"\\f543\";\n}\n\n.fa-square-pen::before {\n  content: \"\\f14b\";\n}\n\n.fa-pen-square::before {\n  content: \"\\f14b\";\n}\n\n.fa-pencil-square::before {\n  content: \"\\f14b\";\n}\n\n.fa-suitcase-rolling::before {\n  content: \"\\f5c1\";\n}\n\n.fa-person-circle-exclamation::before {\n  content: \"\\e53f\";\n}\n\n.fa-chevron-down::before {\n  content: \"\\f078\";\n}\n\n.fa-battery-full::before {\n  content: \"\\f240\";\n}\n\n.fa-battery::before {\n  content: \"\\f240\";\n}\n\n.fa-battery-5::before {\n  content: \"\\f240\";\n}\n\n.fa-skull-crossbones::before {\n  content: \"\\f714\";\n}\n\n.fa-code-compare::before {\n  content: \"\\e13a\";\n}\n\n.fa-list-ul::before {\n  content: \"\\f0ca\";\n}\n\n.fa-list-dots::before {\n  content: \"\\f0ca\";\n}\n\n.fa-school-lock::before {\n  content: \"\\e56f\";\n}\n\n.fa-tower-cell::before {\n  content: \"\\e585\";\n}\n\n.fa-down-long::before {\n  content: \"\\f309\";\n}\n\n.fa-long-arrow-alt-down::before {\n  content: \"\\f309\";\n}\n\n.fa-ranking-star::before {\n  content: \"\\e561\";\n}\n\n.fa-chess-king::before {\n  content: \"\\f43f\";\n}\n\n.fa-person-harassing::before {\n  content: \"\\e549\";\n}\n\n.fa-brazilian-real-sign::before {\n  content: \"\\e46c\";\n}\n\n.fa-landmark-dome::before {\n  content: \"\\f752\";\n}\n\n.fa-landmark-alt::before {\n  content: \"\\f752\";\n}\n\n.fa-arrow-up::before {\n  content: \"\\f062\";\n}\n\n.fa-tv::before {\n  content: \"\\f26c\";\n}\n\n.fa-television::before {\n  content: \"\\f26c\";\n}\n\n.fa-tv-alt::before {\n  content: \"\\f26c\";\n}\n\n.fa-shrimp::before {\n  content: \"\\e448\";\n}\n\n.fa-list-check::before {\n  content: \"\\f0ae\";\n}\n\n.fa-tasks::before {\n  content: \"\\f0ae\";\n}\n\n.fa-jug-detergent::before {\n  content: \"\\e519\";\n}\n\n.fa-circle-user::before {\n  content: \"\\f2bd\";\n}\n\n.fa-user-circle::before {\n  content: \"\\f2bd\";\n}\n\n.fa-user-shield::before {\n  content: \"\\f505\";\n}\n\n.fa-wind::before {\n  content: \"\\f72e\";\n}\n\n.fa-car-burst::before {\n  content: \"\\f5e1\";\n}\n\n.fa-car-crash::before {\n  content: \"\\f5e1\";\n}\n\n.fa-y::before {\n  content: \"Y\";\n}\n\n.fa-person-snowboarding::before {\n  content: \"\\f7ce\";\n}\n\n.fa-snowboarding::before {\n  content: \"\\f7ce\";\n}\n\n.fa-truck-fast::before {\n  content: \"\\f48b\";\n}\n\n.fa-shipping-fast::before {\n  content: \"\\f48b\";\n}\n\n.fa-fish::before {\n  content: \"\\f578\";\n}\n\n.fa-user-graduate::before {\n  content: \"\\f501\";\n}\n\n.fa-circle-half-stroke::before {\n  content: \"\\f042\";\n}\n\n.fa-adjust::before {\n  content: \"\\f042\";\n}\n\n.fa-clapperboard::before {\n  content: \"\\e131\";\n}\n\n.fa-circle-radiation::before {\n  content: \"\\f7ba\";\n}\n\n.fa-radiation-alt::before {\n  content: \"\\f7ba\";\n}\n\n.fa-baseball::before {\n  content: \"\\f433\";\n}\n\n.fa-baseball-ball::before {\n  content: \"\\f433\";\n}\n\n.fa-jet-fighter-up::before {\n  content: \"\\e518\";\n}\n\n.fa-diagram-project::before {\n  content: \"\\f542\";\n}\n\n.fa-project-diagram::before {\n  content: \"\\f542\";\n}\n\n.fa-copy::before {\n  content: \"\\f0c5\";\n}\n\n.fa-volume-xmark::before {\n  content: \"\\f6a9\";\n}\n\n.fa-volume-mute::before {\n  content: \"\\f6a9\";\n}\n\n.fa-volume-times::before {\n  content: \"\\f6a9\";\n}\n\n.fa-hand-sparkles::before {\n  content: \"\\e05d\";\n}\n\n.fa-grip::before {\n  content: \"\\f58d\";\n}\n\n.fa-grip-horizontal::before {\n  content: \"\\f58d\";\n}\n\n.fa-share-from-square::before {\n  content: \"\\f14d\";\n}\n\n.fa-share-square::before {\n  content: \"\\f14d\";\n}\n\n.fa-gun::before {\n  content: \"\\e19b\";\n}\n\n.fa-square-phone::before {\n  content: \"\\f098\";\n}\n\n.fa-phone-square::before {\n  content: \"\\f098\";\n}\n\n.fa-plus::before {\n  content: \"\\+\";\n}\n\n.fa-add::before {\n  content: \"\\+\";\n}\n\n.fa-expand::before {\n  content: \"\\f065\";\n}\n\n.fa-computer::before {\n  content: \"\\e4e5\";\n}\n\n.fa-xmark::before {\n  content: \"\\f00d\";\n}\n\n.fa-close::before {\n  content: \"\\f00d\";\n}\n\n.fa-multiply::before {\n  content: \"\\f00d\";\n}\n\n.fa-remove::before {\n  content: \"\\f00d\";\n}\n\n.fa-times::before {\n  content: \"\\f00d\";\n}\n\n.fa-arrows-up-down-left-right::before {\n  content: \"\\f047\";\n}\n\n.fa-arrows::before {\n  content: \"\\f047\";\n}\n\n.fa-chalkboard-user::before {\n  content: \"\\f51c\";\n}\n\n.fa-chalkboard-teacher::before {\n  content: \"\\f51c\";\n}\n\n.fa-peso-sign::before {\n  content: \"\\e222\";\n}\n\n.fa-building-shield::before {\n  content: \"\\e4d8\";\n}\n\n.fa-baby::before {\n  content: \"\\f77c\";\n}\n\n.fa-users-line::before {\n  content: \"\\e592\";\n}\n\n.fa-quote-left::before {\n  content: \"\\f10d\";\n}\n\n.fa-quote-left-alt::before {\n  content: \"\\f10d\";\n}\n\n.fa-tractor::before {\n  content: \"\\f722\";\n}\n\n.fa-trash-arrow-up::before {\n  content: \"\\f829\";\n}\n\n.fa-trash-restore::before {\n  content: \"\\f829\";\n}\n\n.fa-arrow-down-up-lock::before {\n  content: \"\\e4b0\";\n}\n\n.fa-lines-leaning::before {\n  content: \"\\e51e\";\n}\n\n.fa-ruler-combined::before {\n  content: \"\\f546\";\n}\n\n.fa-copyright::before {\n  content: \"\\f1f9\";\n}\n\n.fa-equals::before {\n  content: \"\\=\";\n}\n\n.fa-blender::before {\n  content: \"\\f517\";\n}\n\n.fa-teeth::before {\n  content: \"\\f62e\";\n}\n\n.fa-shekel-sign::before {\n  content: \"\\f20b\";\n}\n\n.fa-ils::before {\n  content: \"\\f20b\";\n}\n\n.fa-shekel::before {\n  content: \"\\f20b\";\n}\n\n.fa-sheqel::before {\n  content: \"\\f20b\";\n}\n\n.fa-sheqel-sign::before {\n  content: \"\\f20b\";\n}\n\n.fa-map::before {\n  content: \"\\f279\";\n}\n\n.fa-rocket::before {\n  content: \"\\f135\";\n}\n\n.fa-photo-film::before {\n  content: \"\\f87c\";\n}\n\n.fa-photo-video::before {\n  content: \"\\f87c\";\n}\n\n.fa-folder-minus::before {\n  content: \"\\f65d\";\n}\n\n.fa-store::before {\n  content: \"\\f54e\";\n}\n\n.fa-arrow-trend-up::before {\n  content: \"\\e098\";\n}\n\n.fa-plug-circle-minus::before {\n  content: \"\\e55e\";\n}\n\n.fa-sign-hanging::before {\n  content: \"\\f4d9\";\n}\n\n.fa-sign::before {\n  content: \"\\f4d9\";\n}\n\n.fa-bezier-curve::before {\n  content: \"\\f55b\";\n}\n\n.fa-bell-slash::before {\n  content: \"\\f1f6\";\n}\n\n.fa-tablet::before {\n  content: \"\\f3fb\";\n}\n\n.fa-tablet-android::before {\n  content: \"\\f3fb\";\n}\n\n.fa-school-flag::before {\n  content: \"\\e56e\";\n}\n\n.fa-fill::before {\n  content: \"\\f575\";\n}\n\n.fa-angle-up::before {\n  content: \"\\f106\";\n}\n\n.fa-drumstick-bite::before {\n  content: \"\\f6d7\";\n}\n\n.fa-holly-berry::before {\n  content: \"\\f7aa\";\n}\n\n.fa-chevron-left::before {\n  content: \"\\f053\";\n}\n\n.fa-bacteria::before {\n  content: \"\\e059\";\n}\n\n.fa-hand-lizard::before {\n  content: \"\\f258\";\n}\n\n.fa-disease::before {\n  content: \"\\f7fa\";\n}\n\n.fa-briefcase-medical::before {\n  content: \"\\f469\";\n}\n\n.fa-genderless::before {\n  content: \"\\f22d\";\n}\n\n.fa-chevron-right::before {\n  content: \"\\f054\";\n}\n\n.fa-retweet::before {\n  content: \"\\f079\";\n}\n\n.fa-car-rear::before {\n  content: \"\\f5de\";\n}\n\n.fa-car-alt::before {\n  content: \"\\f5de\";\n}\n\n.fa-pump-soap::before {\n  content: \"\\e06b\";\n}\n\n.fa-video-slash::before {\n  content: \"\\f4e2\";\n}\n\n.fa-battery-quarter::before {\n  content: \"\\f243\";\n}\n\n.fa-battery-2::before {\n  content: \"\\f243\";\n}\n\n.fa-radio::before {\n  content: \"\\f8d7\";\n}\n\n.fa-baby-carriage::before {\n  content: \"\\f77d\";\n}\n\n.fa-carriage-baby::before {\n  content: \"\\f77d\";\n}\n\n.fa-traffic-light::before {\n  content: \"\\f637\";\n}\n\n.fa-thermometer::before {\n  content: \"\\f491\";\n}\n\n.fa-vr-cardboard::before {\n  content: \"\\f729\";\n}\n\n.fa-hand-middle-finger::before {\n  content: \"\\f806\";\n}\n\n.fa-percent::before {\n  content: \"\\%\";\n}\n\n.fa-percentage::before {\n  content: \"\\%\";\n}\n\n.fa-truck-moving::before {\n  content: \"\\f4df\";\n}\n\n.fa-glass-water-droplet::before {\n  content: \"\\e4f5\";\n}\n\n.fa-display::before {\n  content: \"\\e163\";\n}\n\n.fa-face-smile::before {\n  content: \"\\f118\";\n}\n\n.fa-smile::before {\n  content: \"\\f118\";\n}\n\n.fa-thumbtack::before {\n  content: \"\\f08d\";\n}\n\n.fa-thumb-tack::before {\n  content: \"\\f08d\";\n}\n\n.fa-trophy::before {\n  content: \"\\f091\";\n}\n\n.fa-person-praying::before {\n  content: \"\\f683\";\n}\n\n.fa-pray::before {\n  content: \"\\f683\";\n}\n\n.fa-hammer::before {\n  content: \"\\f6e3\";\n}\n\n.fa-hand-peace::before {\n  content: \"\\f25b\";\n}\n\n.fa-rotate::before {\n  content: \"\\f2f1\";\n}\n\n.fa-sync-alt::before {\n  content: \"\\f2f1\";\n}\n\n.fa-spinner::before {\n  content: \"\\f110\";\n}\n\n.fa-robot::before {\n  content: \"\\f544\";\n}\n\n.fa-peace::before {\n  content: \"\\f67c\";\n}\n\n.fa-gears::before {\n  content: \"\\f085\";\n}\n\n.fa-cogs::before {\n  content: \"\\f085\";\n}\n\n.fa-warehouse::before {\n  content: \"\\f494\";\n}\n\n.fa-arrow-up-right-dots::before {\n  content: \"\\e4b7\";\n}\n\n.fa-splotch::before {\n  content: \"\\f5bc\";\n}\n\n.fa-face-grin-hearts::before {\n  content: \"\\f584\";\n}\n\n.fa-grin-hearts::before {\n  content: \"\\f584\";\n}\n\n.fa-dice-four::before {\n  content: \"\\f524\";\n}\n\n.fa-sim-card::before {\n  content: \"\\f7c4\";\n}\n\n.fa-transgender::before {\n  content: \"\\f225\";\n}\n\n.fa-transgender-alt::before {\n  content: \"\\f225\";\n}\n\n.fa-mercury::before {\n  content: \"\\f223\";\n}\n\n.fa-arrow-turn-down::before {\n  content: \"\\f149\";\n}\n\n.fa-level-down::before {\n  content: \"\\f149\";\n}\n\n.fa-person-falling-burst::before {\n  content: \"\\e547\";\n}\n\n.fa-award::before {\n  content: \"\\f559\";\n}\n\n.fa-ticket-simple::before {\n  content: \"\\f3ff\";\n}\n\n.fa-ticket-alt::before {\n  content: \"\\f3ff\";\n}\n\n.fa-building::before {\n  content: \"\\f1ad\";\n}\n\n.fa-angles-left::before {\n  content: \"\\f100\";\n}\n\n.fa-angle-double-left::before {\n  content: \"\\f100\";\n}\n\n.fa-qrcode::before {\n  content: \"\\f029\";\n}\n\n.fa-clock-rotate-left::before {\n  content: \"\\f1da\";\n}\n\n.fa-history::before {\n  content: \"\\f1da\";\n}\n\n.fa-face-grin-beam-sweat::before {\n  content: \"\\f583\";\n}\n\n.fa-grin-beam-sweat::before {\n  content: \"\\f583\";\n}\n\n.fa-file-export::before {\n  content: \"\\f56e\";\n}\n\n.fa-arrow-right-from-file::before {\n  content: \"\\f56e\";\n}\n\n.fa-shield::before {\n  content: \"\\f132\";\n}\n\n.fa-shield-blank::before {\n  content: \"\\f132\";\n}\n\n.fa-arrow-up-short-wide::before {\n  content: \"\\f885\";\n}\n\n.fa-sort-amount-up-alt::before {\n  content: \"\\f885\";\n}\n\n.fa-house-medical::before {\n  content: \"\\e3b2\";\n}\n\n.fa-golf-ball-tee::before {\n  content: \"\\f450\";\n}\n\n.fa-golf-ball::before {\n  content: \"\\f450\";\n}\n\n.fa-circle-chevron-left::before {\n  content: \"\\f137\";\n}\n\n.fa-chevron-circle-left::before {\n  content: \"\\f137\";\n}\n\n.fa-house-chimney-window::before {\n  content: \"\\e00d\";\n}\n\n.fa-pen-nib::before {\n  content: \"\\f5ad\";\n}\n\n.fa-tent-arrow-turn-left::before {\n  content: \"\\e580\";\n}\n\n.fa-tents::before {\n  content: \"\\e582\";\n}\n\n.fa-wand-magic::before {\n  content: \"\\f0d0\";\n}\n\n.fa-magic::before {\n  content: \"\\f0d0\";\n}\n\n.fa-dog::before {\n  content: \"\\f6d3\";\n}\n\n.fa-carrot::before {\n  content: \"\\f787\";\n}\n\n.fa-moon::before {\n  content: \"\\f186\";\n}\n\n.fa-wine-glass-empty::before {\n  content: \"\\f5ce\";\n}\n\n.fa-wine-glass-alt::before {\n  content: \"\\f5ce\";\n}\n\n.fa-cheese::before {\n  content: \"\\f7ef\";\n}\n\n.fa-yin-yang::before {\n  content: \"\\f6ad\";\n}\n\n.fa-music::before {\n  content: \"\\f001\";\n}\n\n.fa-code-commit::before {\n  content: \"\\f386\";\n}\n\n.fa-temperature-low::before {\n  content: \"\\f76b\";\n}\n\n.fa-person-biking::before {\n  content: \"\\f84a\";\n}\n\n.fa-biking::before {\n  content: \"\\f84a\";\n}\n\n.fa-broom::before {\n  content: \"\\f51a\";\n}\n\n.fa-shield-heart::before {\n  content: \"\\e574\";\n}\n\n.fa-gopuram::before {\n  content: \"\\f664\";\n}\n\n.fa-earth-oceania::before {\n  content: \"\\e47b\";\n}\n\n.fa-globe-oceania::before {\n  content: \"\\e47b\";\n}\n\n.fa-square-xmark::before {\n  content: \"\\f2d3\";\n}\n\n.fa-times-square::before {\n  content: \"\\f2d3\";\n}\n\n.fa-xmark-square::before {\n  content: \"\\f2d3\";\n}\n\n.fa-hashtag::before {\n  content: \"\\#\";\n}\n\n.fa-up-right-and-down-left-from-center::before {\n  content: \"\\f424\";\n}\n\n.fa-expand-alt::before {\n  content: \"\\f424\";\n}\n\n.fa-oil-can::before {\n  content: \"\\f613\";\n}\n\n.fa-t::before {\n  content: \"T\";\n}\n\n.fa-hippo::before {\n  content: \"\\f6ed\";\n}\n\n.fa-chart-column::before {\n  content: \"\\e0e3\";\n}\n\n.fa-infinity::before {\n  content: \"\\f534\";\n}\n\n.fa-vial-circle-check::before {\n  content: \"\\e596\";\n}\n\n.fa-person-arrow-down-to-line::before {\n  content: \"\\e538\";\n}\n\n.fa-voicemail::before {\n  content: \"\\f897\";\n}\n\n.fa-fan::before {\n  content: \"\\f863\";\n}\n\n.fa-person-walking-luggage::before {\n  content: \"\\e554\";\n}\n\n.fa-up-down::before {\n  content: \"\\f338\";\n}\n\n.fa-arrows-alt-v::before {\n  content: \"\\f338\";\n}\n\n.fa-cloud-moon-rain::before {\n  content: \"\\f73c\";\n}\n\n.fa-calendar::before {\n  content: \"\\f133\";\n}\n\n.fa-trailer::before {\n  content: \"\\e041\";\n}\n\n.fa-bahai::before {\n  content: \"\\f666\";\n}\n\n.fa-haykal::before {\n  content: \"\\f666\";\n}\n\n.fa-sd-card::before {\n  content: \"\\f7c2\";\n}\n\n.fa-dragon::before {\n  content: \"\\f6d5\";\n}\n\n.fa-shoe-prints::before {\n  content: \"\\f54b\";\n}\n\n.fa-circle-plus::before {\n  content: \"\\f055\";\n}\n\n.fa-plus-circle::before {\n  content: \"\\f055\";\n}\n\n.fa-face-grin-tongue-wink::before {\n  content: \"\\f58b\";\n}\n\n.fa-grin-tongue-wink::before {\n  content: \"\\f58b\";\n}\n\n.fa-hand-holding::before {\n  content: \"\\f4bd\";\n}\n\n.fa-plug-circle-exclamation::before {\n  content: \"\\e55d\";\n}\n\n.fa-link-slash::before {\n  content: \"\\f127\";\n}\n\n.fa-chain-broken::before {\n  content: \"\\f127\";\n}\n\n.fa-chain-slash::before {\n  content: \"\\f127\";\n}\n\n.fa-unlink::before {\n  content: \"\\f127\";\n}\n\n.fa-clone::before {\n  content: \"\\f24d\";\n}\n\n.fa-person-walking-arrow-loop-left::before {\n  content: \"\\e551\";\n}\n\n.fa-arrow-up-z-a::before {\n  content: \"\\f882\";\n}\n\n.fa-sort-alpha-up-alt::before {\n  content: \"\\f882\";\n}\n\n.fa-fire-flame-curved::before {\n  content: \"\\f7e4\";\n}\n\n.fa-fire-alt::before {\n  content: \"\\f7e4\";\n}\n\n.fa-tornado::before {\n  content: \"\\f76f\";\n}\n\n.fa-file-circle-plus::before {\n  content: \"\\e494\";\n}\n\n.fa-book-quran::before {\n  content: \"\\f687\";\n}\n\n.fa-quran::before {\n  content: \"\\f687\";\n}\n\n.fa-anchor::before {\n  content: \"\\f13d\";\n}\n\n.fa-border-all::before {\n  content: \"\\f84c\";\n}\n\n.fa-face-angry::before {\n  content: \"\\f556\";\n}\n\n.fa-angry::before {\n  content: \"\\f556\";\n}\n\n.fa-cookie-bite::before {\n  content: \"\\f564\";\n}\n\n.fa-arrow-trend-down::before {\n  content: \"\\e097\";\n}\n\n.fa-rss::before {\n  content: \"\\f09e\";\n}\n\n.fa-feed::before {\n  content: \"\\f09e\";\n}\n\n.fa-draw-polygon::before {\n  content: \"\\f5ee\";\n}\n\n.fa-scale-balanced::before {\n  content: \"\\f24e\";\n}\n\n.fa-balance-scale::before {\n  content: \"\\f24e\";\n}\n\n.fa-gauge-simple-high::before {\n  content: \"\\f62a\";\n}\n\n.fa-tachometer::before {\n  content: \"\\f62a\";\n}\n\n.fa-tachometer-fast::before {\n  content: \"\\f62a\";\n}\n\n.fa-shower::before {\n  content: \"\\f2cc\";\n}\n\n.fa-desktop::before {\n  content: \"\\f390\";\n}\n\n.fa-desktop-alt::before {\n  content: \"\\f390\";\n}\n\n.fa-m::before {\n  content: \"M\";\n}\n\n.fa-table-list::before {\n  content: \"\\f00b\";\n}\n\n.fa-th-list::before {\n  content: \"\\f00b\";\n}\n\n.fa-comment-sms::before {\n  content: \"\\f7cd\";\n}\n\n.fa-sms::before {\n  content: \"\\f7cd\";\n}\n\n.fa-book::before {\n  content: \"\\f02d\";\n}\n\n.fa-user-plus::before {\n  content: \"\\f234\";\n}\n\n.fa-check::before {\n  content: \"\\f00c\";\n}\n\n.fa-battery-three-quarters::before {\n  content: \"\\f241\";\n}\n\n.fa-battery-4::before {\n  content: \"\\f241\";\n}\n\n.fa-house-circle-check::before {\n  content: \"\\e509\";\n}\n\n.fa-angle-left::before {\n  content: \"\\f104\";\n}\n\n.fa-diagram-successor::before {\n  content: \"\\e47a\";\n}\n\n.fa-truck-arrow-right::before {\n  content: \"\\e58b\";\n}\n\n.fa-arrows-split-up-and-left::before {\n  content: \"\\e4bc\";\n}\n\n.fa-hand-fist::before {\n  content: \"\\f6de\";\n}\n\n.fa-fist-raised::before {\n  content: \"\\f6de\";\n}\n\n.fa-cloud-moon::before {\n  content: \"\\f6c3\";\n}\n\n.fa-briefcase::before {\n  content: \"\\f0b1\";\n}\n\n.fa-person-falling::before {\n  content: \"\\e546\";\n}\n\n.fa-image-portrait::before {\n  content: \"\\f3e0\";\n}\n\n.fa-portrait::before {\n  content: \"\\f3e0\";\n}\n\n.fa-user-tag::before {\n  content: \"\\f507\";\n}\n\n.fa-rug::before {\n  content: \"\\e569\";\n}\n\n.fa-earth-europe::before {\n  content: \"\\f7a2\";\n}\n\n.fa-globe-europe::before {\n  content: \"\\f7a2\";\n}\n\n.fa-cart-flatbed-suitcase::before {\n  content: \"\\f59d\";\n}\n\n.fa-luggage-cart::before {\n  content: \"\\f59d\";\n}\n\n.fa-rectangle-xmark::before {\n  content: \"\\f410\";\n}\n\n.fa-rectangle-times::before {\n  content: \"\\f410\";\n}\n\n.fa-times-rectangle::before {\n  content: \"\\f410\";\n}\n\n.fa-window-close::before {\n  content: \"\\f410\";\n}\n\n.fa-baht-sign::before {\n  content: \"\\e0ac\";\n}\n\n.fa-book-open::before {\n  content: \"\\f518\";\n}\n\n.fa-book-journal-whills::before {\n  content: \"\\f66a\";\n}\n\n.fa-journal-whills::before {\n  content: \"\\f66a\";\n}\n\n.fa-handcuffs::before {\n  content: \"\\e4f8\";\n}\n\n.fa-triangle-exclamation::before {\n  content: \"\\f071\";\n}\n\n.fa-exclamation-triangle::before {\n  content: \"\\f071\";\n}\n\n.fa-warning::before {\n  content: \"\\f071\";\n}\n\n.fa-database::before {\n  content: \"\\f1c0\";\n}\n\n.fa-share::before {\n  content: \"\\f064\";\n}\n\n.fa-arrow-turn-right::before {\n  content: \"\\f064\";\n}\n\n.fa-mail-forward::before {\n  content: \"\\f064\";\n}\n\n.fa-bottle-droplet::before {\n  content: \"\\e4c4\";\n}\n\n.fa-mask-face::before {\n  content: \"\\e1d7\";\n}\n\n.fa-hill-rockslide::before {\n  content: \"\\e508\";\n}\n\n.fa-right-left::before {\n  content: \"\\f362\";\n}\n\n.fa-exchange-alt::before {\n  content: \"\\f362\";\n}\n\n.fa-paper-plane::before {\n  content: \"\\f1d8\";\n}\n\n.fa-road-circle-exclamation::before {\n  content: \"\\e565\";\n}\n\n.fa-dungeon::before {\n  content: \"\\f6d9\";\n}\n\n.fa-align-right::before {\n  content: \"\\f038\";\n}\n\n.fa-money-bill-1-wave::before {\n  content: \"\\f53b\";\n}\n\n.fa-money-bill-wave-alt::before {\n  content: \"\\f53b\";\n}\n\n.fa-life-ring::before {\n  content: \"\\f1cd\";\n}\n\n.fa-hands::before {\n  content: \"\\f2a7\";\n}\n\n.fa-sign-language::before {\n  content: \"\\f2a7\";\n}\n\n.fa-signing::before {\n  content: \"\\f2a7\";\n}\n\n.fa-calendar-day::before {\n  content: \"\\f783\";\n}\n\n.fa-water-ladder::before {\n  content: \"\\f5c5\";\n}\n\n.fa-ladder-water::before {\n  content: \"\\f5c5\";\n}\n\n.fa-swimming-pool::before {\n  content: \"\\f5c5\";\n}\n\n.fa-arrows-up-down::before {\n  content: \"\\f07d\";\n}\n\n.fa-arrows-v::before {\n  content: \"\\f07d\";\n}\n\n.fa-face-grimace::before {\n  content: \"\\f57f\";\n}\n\n.fa-grimace::before {\n  content: \"\\f57f\";\n}\n\n.fa-wheelchair-move::before {\n  content: \"\\e2ce\";\n}\n\n.fa-wheelchair-alt::before {\n  content: \"\\e2ce\";\n}\n\n.fa-turn-down::before {\n  content: \"\\f3be\";\n}\n\n.fa-level-down-alt::before {\n  content: \"\\f3be\";\n}\n\n.fa-person-walking-arrow-right::before {\n  content: \"\\e552\";\n}\n\n.fa-square-envelope::before {\n  content: \"\\f199\";\n}\n\n.fa-envelope-square::before {\n  content: \"\\f199\";\n}\n\n.fa-dice::before {\n  content: \"\\f522\";\n}\n\n.fa-bowling-ball::before {\n  content: \"\\f436\";\n}\n\n.fa-brain::before {\n  content: \"\\f5dc\";\n}\n\n.fa-bandage::before {\n  content: \"\\f462\";\n}\n\n.fa-band-aid::before {\n  content: \"\\f462\";\n}\n\n.fa-calendar-minus::before {\n  content: \"\\f272\";\n}\n\n.fa-circle-xmark::before {\n  content: \"\\f057\";\n}\n\n.fa-times-circle::before {\n  content: \"\\f057\";\n}\n\n.fa-xmark-circle::before {\n  content: \"\\f057\";\n}\n\n.fa-gifts::before {\n  content: \"\\f79c\";\n}\n\n.fa-hotel::before {\n  content: \"\\f594\";\n}\n\n.fa-earth-asia::before {\n  content: \"\\f57e\";\n}\n\n.fa-globe-asia::before {\n  content: \"\\f57e\";\n}\n\n.fa-id-card-clip::before {\n  content: \"\\f47f\";\n}\n\n.fa-id-card-alt::before {\n  content: \"\\f47f\";\n}\n\n.fa-magnifying-glass-plus::before {\n  content: \"\\f00e\";\n}\n\n.fa-search-plus::before {\n  content: \"\\f00e\";\n}\n\n.fa-thumbs-up::before {\n  content: \"\\f164\";\n}\n\n.fa-user-clock::before {\n  content: \"\\f4fd\";\n}\n\n.fa-hand-dots::before {\n  content: \"\\f461\";\n}\n\n.fa-allergies::before {\n  content: \"\\f461\";\n}\n\n.fa-file-invoice::before {\n  content: \"\\f570\";\n}\n\n.fa-window-minimize::before {\n  content: \"\\f2d1\";\n}\n\n.fa-mug-saucer::before {\n  content: \"\\f0f4\";\n}\n\n.fa-coffee::before {\n  content: \"\\f0f4\";\n}\n\n.fa-brush::before {\n  content: \"\\f55d\";\n}\n\n.fa-mask::before {\n  content: \"\\f6fa\";\n}\n\n.fa-magnifying-glass-minus::before {\n  content: \"\\f010\";\n}\n\n.fa-search-minus::before {\n  content: \"\\f010\";\n}\n\n.fa-ruler-vertical::before {\n  content: \"\\f548\";\n}\n\n.fa-user-large::before {\n  content: \"\\f406\";\n}\n\n.fa-user-alt::before {\n  content: \"\\f406\";\n}\n\n.fa-train-tram::before {\n  content: \"\\e5b4\";\n}\n\n.fa-user-nurse::before {\n  content: \"\\f82f\";\n}\n\n.fa-syringe::before {\n  content: \"\\f48e\";\n}\n\n.fa-cloud-sun::before {\n  content: \"\\f6c4\";\n}\n\n.fa-stopwatch-20::before {\n  content: \"\\e06f\";\n}\n\n.fa-square-full::before {\n  content: \"\\f45c\";\n}\n\n.fa-magnet::before {\n  content: \"\\f076\";\n}\n\n.fa-jar::before {\n  content: \"\\e516\";\n}\n\n.fa-note-sticky::before {\n  content: \"\\f249\";\n}\n\n.fa-sticky-note::before {\n  content: \"\\f249\";\n}\n\n.fa-bug-slash::before {\n  content: \"\\e490\";\n}\n\n.fa-arrow-up-from-water-pump::before {\n  content: \"\\e4b6\";\n}\n\n.fa-bone::before {\n  content: \"\\f5d7\";\n}\n\n.fa-user-injured::before {\n  content: \"\\f728\";\n}\n\n.fa-face-sad-tear::before {\n  content: \"\\f5b4\";\n}\n\n.fa-sad-tear::before {\n  content: \"\\f5b4\";\n}\n\n.fa-plane::before {\n  content: \"\\f072\";\n}\n\n.fa-tent-arrows-down::before {\n  content: \"\\e581\";\n}\n\n.fa-exclamation::before {\n  content: \"\\!\";\n}\n\n.fa-arrows-spin::before {\n  content: \"\\e4bb\";\n}\n\n.fa-print::before {\n  content: \"\\f02f\";\n}\n\n.fa-turkish-lira-sign::before {\n  content: \"\\e2bb\";\n}\n\n.fa-try::before {\n  content: \"\\e2bb\";\n}\n\n.fa-turkish-lira::before {\n  content: \"\\e2bb\";\n}\n\n.fa-dollar-sign::before {\n  content: \"\\$\";\n}\n\n.fa-dollar::before {\n  content: \"\\$\";\n}\n\n.fa-usd::before {\n  content: \"\\$\";\n}\n\n.fa-x::before {\n  content: \"X\";\n}\n\n.fa-magnifying-glass-dollar::before {\n  content: \"\\f688\";\n}\n\n.fa-search-dollar::before {\n  content: \"\\f688\";\n}\n\n.fa-users-gear::before {\n  content: \"\\f509\";\n}\n\n.fa-users-cog::before {\n  content: \"\\f509\";\n}\n\n.fa-person-military-pointing::before {\n  content: \"\\e54a\";\n}\n\n.fa-building-columns::before {\n  content: \"\\f19c\";\n}\n\n.fa-bank::before {\n  content: \"\\f19c\";\n}\n\n.fa-institution::before {\n  content: \"\\f19c\";\n}\n\n.fa-museum::before {\n  content: \"\\f19c\";\n}\n\n.fa-university::before {\n  content: \"\\f19c\";\n}\n\n.fa-umbrella::before {\n  content: \"\\f0e9\";\n}\n\n.fa-trowel::before {\n  content: \"\\e589\";\n}\n\n.fa-d::before {\n  content: \"D\";\n}\n\n.fa-stapler::before {\n  content: \"\\e5af\";\n}\n\n.fa-masks-theater::before {\n  content: \"\\f630\";\n}\n\n.fa-theater-masks::before {\n  content: \"\\f630\";\n}\n\n.fa-kip-sign::before {\n  content: \"\\e1c4\";\n}\n\n.fa-hand-point-left::before {\n  content: \"\\f0a5\";\n}\n\n.fa-handshake-simple::before {\n  content: \"\\f4c6\";\n}\n\n.fa-handshake-alt::before {\n  content: \"\\f4c6\";\n}\n\n.fa-jet-fighter::before {\n  content: \"\\f0fb\";\n}\n\n.fa-fighter-jet::before {\n  content: \"\\f0fb\";\n}\n\n.fa-square-share-nodes::before {\n  content: \"\\f1e1\";\n}\n\n.fa-share-alt-square::before {\n  content: \"\\f1e1\";\n}\n\n.fa-barcode::before {\n  content: \"\\f02a\";\n}\n\n.fa-plus-minus::before {\n  content: \"\\e43c\";\n}\n\n.fa-video::before {\n  content: \"\\f03d\";\n}\n\n.fa-video-camera::before {\n  content: \"\\f03d\";\n}\n\n.fa-graduation-cap::before {\n  content: \"\\f19d\";\n}\n\n.fa-mortar-board::before {\n  content: \"\\f19d\";\n}\n\n.fa-hand-holding-medical::before {\n  content: \"\\e05c\";\n}\n\n.fa-person-circle-check::before {\n  content: \"\\e53e\";\n}\n\n.fa-turn-up::before {\n  content: \"\\f3bf\";\n}\n\n.fa-level-up-alt::before {\n  content: \"\\f3bf\";\n}\n\n.sr-only,\n.fa-sr-only {\n  position: absolute;\n  width: 1px;\n  height: 1px;\n  padding: 0;\n  margin: -1px;\n  overflow: hidden;\n  clip: rect(0, 0, 0, 0);\n  white-space: nowrap;\n  border-width: 0;\n}\n\n.sr-only-focusable:not(:focus),\n.fa-sr-only-focusable:not(:focus) {\n  position: absolute;\n  width: 1px;\n  height: 1px;\n  padding: 0;\n  margin: -1px;\n  overflow: hidden;\n  clip: rect(0, 0, 0, 0);\n  white-space: nowrap;\n  border-width: 0;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/regular.scss":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/regular.scss ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/getUrl.js */ "./node_modules/css-loader/dist/runtime/getUrl.js");
/* harmony import */ var _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _webfonts_fa_regular_400_woff2__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../webfonts/fa-regular-400.woff2 */ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2");
/* harmony import */ var _webfonts_fa_regular_400_ttf__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../webfonts/fa-regular-400.ttf */ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.ttf");
// Imports




var ___CSS_LOADER_EXPORT___ = _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
var ___CSS_LOADER_URL_REPLACEMENT_0___ = _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default()(_webfonts_fa_regular_400_woff2__WEBPACK_IMPORTED_MODULE_2__["default"]);
var ___CSS_LOADER_URL_REPLACEMENT_1___ = _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default()(_webfonts_fa_regular_400_ttf__WEBPACK_IMPORTED_MODULE_3__["default"]);
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/*!\n * Font Awesome Free 6.2.0 by @fontawesome - https://fontawesome.com\n * License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)\n * Copyright 2022 Fonticons, Inc.\n */\n:root, :host {\n  --fa-style-family-classic: \"Font Awesome 6 Free\";\n  --fa-font-regular: normal 400 1em/1 \"Font Awesome 6 Free\";\n}\n\n@font-face {\n  font-family: \"Font Awesome 6 Free\";\n  font-style: normal;\n  font-weight: 400;\n  font-display: block;\n  src: url(" + ___CSS_LOADER_URL_REPLACEMENT_0___ + ") format(\"woff2\"), url(" + ___CSS_LOADER_URL_REPLACEMENT_1___ + ") format(\"truetype\");\n}\n.far,\n.fa-regular {\n  font-weight: 400;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/solid.scss":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/solid.scss ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/getUrl.js */ "./node_modules/css-loader/dist/runtime/getUrl.js");
/* harmony import */ var _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _webfonts_fa_solid_900_woff2__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../webfonts/fa-solid-900.woff2 */ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.woff2");
/* harmony import */ var _webfonts_fa_solid_900_ttf__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../webfonts/fa-solid-900.ttf */ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.ttf");
// Imports




var ___CSS_LOADER_EXPORT___ = _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
var ___CSS_LOADER_URL_REPLACEMENT_0___ = _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default()(_webfonts_fa_solid_900_woff2__WEBPACK_IMPORTED_MODULE_2__["default"]);
var ___CSS_LOADER_URL_REPLACEMENT_1___ = _css_loader_dist_runtime_getUrl_js__WEBPACK_IMPORTED_MODULE_1___default()(_webfonts_fa_solid_900_ttf__WEBPACK_IMPORTED_MODULE_3__["default"]);
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/*!\n * Font Awesome Free 6.2.0 by @fontawesome - https://fontawesome.com\n * License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)\n * Copyright 2022 Fonticons, Inc.\n */\n:root, :host {\n  --fa-style-family-classic: \"Font Awesome 6 Free\";\n  --fa-font-solid: normal 900 1em/1 \"Font Awesome 6 Free\";\n}\n\n@font-face {\n  font-family: \"Font Awesome 6 Free\";\n  font-style: normal;\n  font-weight: 900;\n  font-display: block;\n  src: url(" + ___CSS_LOADER_URL_REPLACEMENT_0___ + ") format(\"woff2\"), url(" + ___CSS_LOADER_URL_REPLACEMENT_1___ + ") format(\"truetype\");\n}\n.fas,\n.fa-solid {\n  font-weight: 900;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/v4-shims.scss":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/v4-shims.scss ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "/*!\n * Font Awesome Free 6.2.0 by @fontawesome - https://fontawesome.com\n * License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)\n * Copyright 2022 Fonticons, Inc.\n */\n.fa.fa-glass:before {\n  content: \"\\f000\";\n}\n\n.fa.fa-envelope-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-envelope-o:before {\n  content: \"\\f0e0\";\n}\n\n.fa.fa-star-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-star-o:before {\n  content: \"\\f005\";\n}\n\n.fa.fa-remove:before {\n  content: \"\\f00d\";\n}\n\n.fa.fa-close:before {\n  content: \"\\f00d\";\n}\n\n.fa.fa-gear:before {\n  content: \"\\f013\";\n}\n\n.fa.fa-trash-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-trash-o:before {\n  content: \"\\f2ed\";\n}\n\n.fa.fa-home:before {\n  content: \"\\f015\";\n}\n\n.fa.fa-file-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-o:before {\n  content: \"\\f15b\";\n}\n\n.fa.fa-clock-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-clock-o:before {\n  content: \"\\f017\";\n}\n\n.fa.fa-arrow-circle-o-down {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-arrow-circle-o-down:before {\n  content: \"\\f358\";\n}\n\n.fa.fa-arrow-circle-o-up {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-arrow-circle-o-up:before {\n  content: \"\\f35b\";\n}\n\n.fa.fa-play-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-play-circle-o:before {\n  content: \"\\f144\";\n}\n\n.fa.fa-repeat:before {\n  content: \"\\f01e\";\n}\n\n.fa.fa-rotate-right:before {\n  content: \"\\f01e\";\n}\n\n.fa.fa-refresh:before {\n  content: \"\\f021\";\n}\n\n.fa.fa-list-alt {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-list-alt:before {\n  content: \"\\f022\";\n}\n\n.fa.fa-dedent:before {\n  content: \"\\f03b\";\n}\n\n.fa.fa-video-camera:before {\n  content: \"\\f03d\";\n}\n\n.fa.fa-picture-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-picture-o:before {\n  content: \"\\f03e\";\n}\n\n.fa.fa-photo {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-photo:before {\n  content: \"\\f03e\";\n}\n\n.fa.fa-image {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-image:before {\n  content: \"\\f03e\";\n}\n\n.fa.fa-map-marker:before {\n  content: \"\\f3c5\";\n}\n\n.fa.fa-pencil-square-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-pencil-square-o:before {\n  content: \"\\f044\";\n}\n\n.fa.fa-edit {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-edit:before {\n  content: \"\\f044\";\n}\n\n.fa.fa-share-square-o:before {\n  content: \"\\f14d\";\n}\n\n.fa.fa-check-square-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-check-square-o:before {\n  content: \"\\f14a\";\n}\n\n.fa.fa-arrows:before {\n  content: \"\\f0b2\";\n}\n\n.fa.fa-times-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-times-circle-o:before {\n  content: \"\\f057\";\n}\n\n.fa.fa-check-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-check-circle-o:before {\n  content: \"\\f058\";\n}\n\n.fa.fa-mail-forward:before {\n  content: \"\\f064\";\n}\n\n.fa.fa-expand:before {\n  content: \"\\f424\";\n}\n\n.fa.fa-compress:before {\n  content: \"\\f422\";\n}\n\n.fa.fa-eye {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-eye-slash {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-warning:before {\n  content: \"\\f071\";\n}\n\n.fa.fa-calendar:before {\n  content: \"\\f073\";\n}\n\n.fa.fa-arrows-v:before {\n  content: \"\\f338\";\n}\n\n.fa.fa-arrows-h:before {\n  content: \"\\f337\";\n}\n\n.fa.fa-bar-chart:before {\n  content: \"\\e0e3\";\n}\n\n.fa.fa-bar-chart-o:before {\n  content: \"\\e0e3\";\n}\n\n.fa.fa-twitter-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-twitter-square:before {\n  content: \"\\f081\";\n}\n\n.fa.fa-facebook-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-facebook-square:before {\n  content: \"\\f082\";\n}\n\n.fa.fa-gears:before {\n  content: \"\\f085\";\n}\n\n.fa.fa-thumbs-o-up {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-thumbs-o-up:before {\n  content: \"\\f164\";\n}\n\n.fa.fa-thumbs-o-down {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-thumbs-o-down:before {\n  content: \"\\f165\";\n}\n\n.fa.fa-heart-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-heart-o:before {\n  content: \"\\f004\";\n}\n\n.fa.fa-sign-out:before {\n  content: \"\\f2f5\";\n}\n\n.fa.fa-linkedin-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-linkedin-square:before {\n  content: \"\\f08c\";\n}\n\n.fa.fa-thumb-tack:before {\n  content: \"\\f08d\";\n}\n\n.fa.fa-external-link:before {\n  content: \"\\f35d\";\n}\n\n.fa.fa-sign-in:before {\n  content: \"\\f2f6\";\n}\n\n.fa.fa-github-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-github-square:before {\n  content: \"\\f092\";\n}\n\n.fa.fa-lemon-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-lemon-o:before {\n  content: \"\\f094\";\n}\n\n.fa.fa-square-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-square-o:before {\n  content: \"\\f0c8\";\n}\n\n.fa.fa-bookmark-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-bookmark-o:before {\n  content: \"\\f02e\";\n}\n\n.fa.fa-twitter {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-facebook {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-facebook:before {\n  content: \"\\f39e\";\n}\n\n.fa.fa-facebook-f {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-facebook-f:before {\n  content: \"\\f39e\";\n}\n\n.fa.fa-github {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-credit-card {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-feed:before {\n  content: \"\\f09e\";\n}\n\n.fa.fa-hdd-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hdd-o:before {\n  content: \"\\f0a0\";\n}\n\n.fa.fa-hand-o-right {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-o-right:before {\n  content: \"\\f0a4\";\n}\n\n.fa.fa-hand-o-left {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-o-left:before {\n  content: \"\\f0a5\";\n}\n\n.fa.fa-hand-o-up {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-o-up:before {\n  content: \"\\f0a6\";\n}\n\n.fa.fa-hand-o-down {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-o-down:before {\n  content: \"\\f0a7\";\n}\n\n.fa.fa-globe:before {\n  content: \"\\f57d\";\n}\n\n.fa.fa-tasks:before {\n  content: \"\\f828\";\n}\n\n.fa.fa-arrows-alt:before {\n  content: \"\\f31e\";\n}\n\n.fa.fa-group:before {\n  content: \"\\f0c0\";\n}\n\n.fa.fa-chain:before {\n  content: \"\\f0c1\";\n}\n\n.fa.fa-cut:before {\n  content: \"\\f0c4\";\n}\n\n.fa.fa-files-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-files-o:before {\n  content: \"\\f0c5\";\n}\n\n.fa.fa-floppy-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-floppy-o:before {\n  content: \"\\f0c7\";\n}\n\n.fa.fa-save {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-save:before {\n  content: \"\\f0c7\";\n}\n\n.fa.fa-navicon:before {\n  content: \"\\f0c9\";\n}\n\n.fa.fa-reorder:before {\n  content: \"\\f0c9\";\n}\n\n.fa.fa-magic:before {\n  content: \"\\e2ca\";\n}\n\n.fa.fa-pinterest {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-pinterest-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-pinterest-square:before {\n  content: \"\\f0d3\";\n}\n\n.fa.fa-google-plus-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-google-plus-square:before {\n  content: \"\\f0d4\";\n}\n\n.fa.fa-google-plus {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-google-plus:before {\n  content: \"\\f0d5\";\n}\n\n.fa.fa-money:before {\n  content: \"\\f3d1\";\n}\n\n.fa.fa-unsorted:before {\n  content: \"\\f0dc\";\n}\n\n.fa.fa-sort-desc:before {\n  content: \"\\f0dd\";\n}\n\n.fa.fa-sort-asc:before {\n  content: \"\\f0de\";\n}\n\n.fa.fa-linkedin {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-linkedin:before {\n  content: \"\\f0e1\";\n}\n\n.fa.fa-rotate-left:before {\n  content: \"\\f0e2\";\n}\n\n.fa.fa-legal:before {\n  content: \"\\f0e3\";\n}\n\n.fa.fa-tachometer:before {\n  content: \"\\f625\";\n}\n\n.fa.fa-dashboard:before {\n  content: \"\\f625\";\n}\n\n.fa.fa-comment-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-comment-o:before {\n  content: \"\\f075\";\n}\n\n.fa.fa-comments-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-comments-o:before {\n  content: \"\\f086\";\n}\n\n.fa.fa-flash:before {\n  content: \"\\f0e7\";\n}\n\n.fa.fa-clipboard:before {\n  content: \"\\f0ea\";\n}\n\n.fa.fa-lightbulb-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-lightbulb-o:before {\n  content: \"\\f0eb\";\n}\n\n.fa.fa-exchange:before {\n  content: \"\\f362\";\n}\n\n.fa.fa-cloud-download:before {\n  content: \"\\f0ed\";\n}\n\n.fa.fa-cloud-upload:before {\n  content: \"\\f0ee\";\n}\n\n.fa.fa-bell-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-bell-o:before {\n  content: \"\\f0f3\";\n}\n\n.fa.fa-cutlery:before {\n  content: \"\\f2e7\";\n}\n\n.fa.fa-file-text-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-text-o:before {\n  content: \"\\f15c\";\n}\n\n.fa.fa-building-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-building-o:before {\n  content: \"\\f1ad\";\n}\n\n.fa.fa-hospital-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hospital-o:before {\n  content: \"\\f0f8\";\n}\n\n.fa.fa-tablet:before {\n  content: \"\\f3fa\";\n}\n\n.fa.fa-mobile:before {\n  content: \"\\f3cd\";\n}\n\n.fa.fa-mobile-phone:before {\n  content: \"\\f3cd\";\n}\n\n.fa.fa-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-circle-o:before {\n  content: \"\\f111\";\n}\n\n.fa.fa-mail-reply:before {\n  content: \"\\f3e5\";\n}\n\n.fa.fa-github-alt {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-folder-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-folder-o:before {\n  content: \"\\f07b\";\n}\n\n.fa.fa-folder-open-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-folder-open-o:before {\n  content: \"\\f07c\";\n}\n\n.fa.fa-smile-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-smile-o:before {\n  content: \"\\f118\";\n}\n\n.fa.fa-frown-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-frown-o:before {\n  content: \"\\f119\";\n}\n\n.fa.fa-meh-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-meh-o:before {\n  content: \"\\f11a\";\n}\n\n.fa.fa-keyboard-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-keyboard-o:before {\n  content: \"\\f11c\";\n}\n\n.fa.fa-flag-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-flag-o:before {\n  content: \"\\f024\";\n}\n\n.fa.fa-mail-reply-all:before {\n  content: \"\\f122\";\n}\n\n.fa.fa-star-half-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-star-half-o:before {\n  content: \"\\f5c0\";\n}\n\n.fa.fa-star-half-empty {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-star-half-empty:before {\n  content: \"\\f5c0\";\n}\n\n.fa.fa-star-half-full {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-star-half-full:before {\n  content: \"\\f5c0\";\n}\n\n.fa.fa-code-fork:before {\n  content: \"\\f126\";\n}\n\n.fa.fa-chain-broken:before {\n  content: \"\\f127\";\n}\n\n.fa.fa-unlink:before {\n  content: \"\\f127\";\n}\n\n.fa.fa-calendar-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-calendar-o:before {\n  content: \"\\f133\";\n}\n\n.fa.fa-maxcdn {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-html5 {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-css3 {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-unlock-alt:before {\n  content: \"\\f09c\";\n}\n\n.fa.fa-minus-square-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-minus-square-o:before {\n  content: \"\\f146\";\n}\n\n.fa.fa-level-up:before {\n  content: \"\\f3bf\";\n}\n\n.fa.fa-level-down:before {\n  content: \"\\f3be\";\n}\n\n.fa.fa-pencil-square:before {\n  content: \"\\f14b\";\n}\n\n.fa.fa-external-link-square:before {\n  content: \"\\f360\";\n}\n\n.fa.fa-compass {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-caret-square-o-down {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-caret-square-o-down:before {\n  content: \"\\f150\";\n}\n\n.fa.fa-toggle-down {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-toggle-down:before {\n  content: \"\\f150\";\n}\n\n.fa.fa-caret-square-o-up {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-caret-square-o-up:before {\n  content: \"\\f151\";\n}\n\n.fa.fa-toggle-up {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-toggle-up:before {\n  content: \"\\f151\";\n}\n\n.fa.fa-caret-square-o-right {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-caret-square-o-right:before {\n  content: \"\\f152\";\n}\n\n.fa.fa-toggle-right {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-toggle-right:before {\n  content: \"\\f152\";\n}\n\n.fa.fa-eur:before {\n  content: \"\\f153\";\n}\n\n.fa.fa-euro:before {\n  content: \"\\f153\";\n}\n\n.fa.fa-gbp:before {\n  content: \"\\f154\";\n}\n\n.fa.fa-usd:before {\n  content: \"\\$\";\n}\n\n.fa.fa-dollar:before {\n  content: \"\\$\";\n}\n\n.fa.fa-inr:before {\n  content: \"\\e1bc\";\n}\n\n.fa.fa-rupee:before {\n  content: \"\\e1bc\";\n}\n\n.fa.fa-jpy:before {\n  content: \"\\f157\";\n}\n\n.fa.fa-cny:before {\n  content: \"\\f157\";\n}\n\n.fa.fa-rmb:before {\n  content: \"\\f157\";\n}\n\n.fa.fa-yen:before {\n  content: \"\\f157\";\n}\n\n.fa.fa-rub:before {\n  content: \"\\f158\";\n}\n\n.fa.fa-ruble:before {\n  content: \"\\f158\";\n}\n\n.fa.fa-rouble:before {\n  content: \"\\f158\";\n}\n\n.fa.fa-krw:before {\n  content: \"\\f159\";\n}\n\n.fa.fa-won:before {\n  content: \"\\f159\";\n}\n\n.fa.fa-btc {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-bitcoin {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-bitcoin:before {\n  content: \"\\f15a\";\n}\n\n.fa.fa-file-text:before {\n  content: \"\\f15c\";\n}\n\n.fa.fa-sort-alpha-asc:before {\n  content: \"\\f15d\";\n}\n\n.fa.fa-sort-alpha-desc:before {\n  content: \"\\f881\";\n}\n\n.fa.fa-sort-amount-asc:before {\n  content: \"\\f884\";\n}\n\n.fa.fa-sort-amount-desc:before {\n  content: \"\\f160\";\n}\n\n.fa.fa-sort-numeric-asc:before {\n  content: \"\\f162\";\n}\n\n.fa.fa-sort-numeric-desc:before {\n  content: \"\\f886\";\n}\n\n.fa.fa-youtube-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-youtube-square:before {\n  content: \"\\f431\";\n}\n\n.fa.fa-youtube {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-xing {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-xing-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-xing-square:before {\n  content: \"\\f169\";\n}\n\n.fa.fa-youtube-play {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-youtube-play:before {\n  content: \"\\f167\";\n}\n\n.fa.fa-dropbox {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-stack-overflow {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-instagram {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-flickr {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-adn {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-bitbucket {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-bitbucket-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-bitbucket-square:before {\n  content: \"\\f171\";\n}\n\n.fa.fa-tumblr {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-tumblr-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-tumblr-square:before {\n  content: \"\\f174\";\n}\n\n.fa.fa-long-arrow-down:before {\n  content: \"\\f309\";\n}\n\n.fa.fa-long-arrow-up:before {\n  content: \"\\f30c\";\n}\n\n.fa.fa-long-arrow-left:before {\n  content: \"\\f30a\";\n}\n\n.fa.fa-long-arrow-right:before {\n  content: \"\\f30b\";\n}\n\n.fa.fa-apple {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-windows {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-android {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-linux {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-dribbble {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-skype {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-foursquare {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-trello {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-gratipay {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-gittip {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-gittip:before {\n  content: \"\\f184\";\n}\n\n.fa.fa-sun-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-sun-o:before {\n  content: \"\\f185\";\n}\n\n.fa.fa-moon-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-moon-o:before {\n  content: \"\\f186\";\n}\n\n.fa.fa-vk {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-weibo {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-renren {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-pagelines {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-stack-exchange {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-arrow-circle-o-right {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-arrow-circle-o-right:before {\n  content: \"\\f35a\";\n}\n\n.fa.fa-arrow-circle-o-left {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-arrow-circle-o-left:before {\n  content: \"\\f359\";\n}\n\n.fa.fa-caret-square-o-left {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-caret-square-o-left:before {\n  content: \"\\f191\";\n}\n\n.fa.fa-toggle-left {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-toggle-left:before {\n  content: \"\\f191\";\n}\n\n.fa.fa-dot-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-dot-circle-o:before {\n  content: \"\\f192\";\n}\n\n.fa.fa-vimeo-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-vimeo-square:before {\n  content: \"\\f194\";\n}\n\n.fa.fa-try:before {\n  content: \"\\e2bb\";\n}\n\n.fa.fa-turkish-lira:before {\n  content: \"\\e2bb\";\n}\n\n.fa.fa-plus-square-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-plus-square-o:before {\n  content: \"\\f0fe\";\n}\n\n.fa.fa-slack {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wordpress {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-openid {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-institution:before {\n  content: \"\\f19c\";\n}\n\n.fa.fa-bank:before {\n  content: \"\\f19c\";\n}\n\n.fa.fa-mortar-board:before {\n  content: \"\\f19d\";\n}\n\n.fa.fa-yahoo {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-google {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-reddit {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-reddit-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-reddit-square:before {\n  content: \"\\f1a2\";\n}\n\n.fa.fa-stumbleupon-circle {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-stumbleupon {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-delicious {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-digg {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-pied-piper-pp {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-pied-piper-alt {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-drupal {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-joomla {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-behance {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-behance-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-behance-square:before {\n  content: \"\\f1b5\";\n}\n\n.fa.fa-steam {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-steam-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-steam-square:before {\n  content: \"\\f1b7\";\n}\n\n.fa.fa-automobile:before {\n  content: \"\\f1b9\";\n}\n\n.fa.fa-cab:before {\n  content: \"\\f1ba\";\n}\n\n.fa.fa-spotify {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-deviantart {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-soundcloud {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-file-pdf-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-pdf-o:before {\n  content: \"\\f1c1\";\n}\n\n.fa.fa-file-word-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-word-o:before {\n  content: \"\\f1c2\";\n}\n\n.fa.fa-file-excel-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-excel-o:before {\n  content: \"\\f1c3\";\n}\n\n.fa.fa-file-powerpoint-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-powerpoint-o:before {\n  content: \"\\f1c4\";\n}\n\n.fa.fa-file-image-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-image-o:before {\n  content: \"\\f1c5\";\n}\n\n.fa.fa-file-photo-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-photo-o:before {\n  content: \"\\f1c5\";\n}\n\n.fa.fa-file-picture-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-picture-o:before {\n  content: \"\\f1c5\";\n}\n\n.fa.fa-file-archive-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-archive-o:before {\n  content: \"\\f1c6\";\n}\n\n.fa.fa-file-zip-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-zip-o:before {\n  content: \"\\f1c6\";\n}\n\n.fa.fa-file-audio-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-audio-o:before {\n  content: \"\\f1c7\";\n}\n\n.fa.fa-file-sound-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-sound-o:before {\n  content: \"\\f1c7\";\n}\n\n.fa.fa-file-video-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-video-o:before {\n  content: \"\\f1c8\";\n}\n\n.fa.fa-file-movie-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-movie-o:before {\n  content: \"\\f1c8\";\n}\n\n.fa.fa-file-code-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-file-code-o:before {\n  content: \"\\f1c9\";\n}\n\n.fa.fa-vine {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-codepen {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-jsfiddle {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-life-bouy:before {\n  content: \"\\f1cd\";\n}\n\n.fa.fa-life-buoy:before {\n  content: \"\\f1cd\";\n}\n\n.fa.fa-life-saver:before {\n  content: \"\\f1cd\";\n}\n\n.fa.fa-support:before {\n  content: \"\\f1cd\";\n}\n\n.fa.fa-circle-o-notch:before {\n  content: \"\\f1ce\";\n}\n\n.fa.fa-rebel {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-ra {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-ra:before {\n  content: \"\\f1d0\";\n}\n\n.fa.fa-resistance {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-resistance:before {\n  content: \"\\f1d0\";\n}\n\n.fa.fa-empire {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-ge {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-ge:before {\n  content: \"\\f1d1\";\n}\n\n.fa.fa-git-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-git-square:before {\n  content: \"\\f1d2\";\n}\n\n.fa.fa-git {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-hacker-news {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-y-combinator-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-y-combinator-square:before {\n  content: \"\\f1d4\";\n}\n\n.fa.fa-yc-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-yc-square:before {\n  content: \"\\f1d4\";\n}\n\n.fa.fa-tencent-weibo {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-qq {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-weixin {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wechat {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wechat:before {\n  content: \"\\f1d7\";\n}\n\n.fa.fa-send:before {\n  content: \"\\f1d8\";\n}\n\n.fa.fa-paper-plane-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-paper-plane-o:before {\n  content: \"\\f1d8\";\n}\n\n.fa.fa-send-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-send-o:before {\n  content: \"\\f1d8\";\n}\n\n.fa.fa-circle-thin {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-circle-thin:before {\n  content: \"\\f111\";\n}\n\n.fa.fa-header:before {\n  content: \"\\f1dc\";\n}\n\n.fa.fa-futbol-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-futbol-o:before {\n  content: \"\\f1e3\";\n}\n\n.fa.fa-soccer-ball-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-soccer-ball-o:before {\n  content: \"\\f1e3\";\n}\n\n.fa.fa-slideshare {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-twitch {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-yelp {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-newspaper-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-newspaper-o:before {\n  content: \"\\f1ea\";\n}\n\n.fa.fa-paypal {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-google-wallet {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc-visa {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc-mastercard {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc-discover {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc-amex {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc-paypal {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc-stripe {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-bell-slash-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-bell-slash-o:before {\n  content: \"\\f1f6\";\n}\n\n.fa.fa-trash:before {\n  content: \"\\f2ed\";\n}\n\n.fa.fa-copyright {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-eyedropper:before {\n  content: \"\\f1fb\";\n}\n\n.fa.fa-area-chart:before {\n  content: \"\\f1fe\";\n}\n\n.fa.fa-pie-chart:before {\n  content: \"\\f200\";\n}\n\n.fa.fa-line-chart:before {\n  content: \"\\f201\";\n}\n\n.fa.fa-lastfm {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-lastfm-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-lastfm-square:before {\n  content: \"\\f203\";\n}\n\n.fa.fa-ioxhost {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-angellist {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-cc:before {\n  content: \"\\f20a\";\n}\n\n.fa.fa-ils:before {\n  content: \"\\f20b\";\n}\n\n.fa.fa-shekel:before {\n  content: \"\\f20b\";\n}\n\n.fa.fa-sheqel:before {\n  content: \"\\f20b\";\n}\n\n.fa.fa-buysellads {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-connectdevelop {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-dashcube {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-forumbee {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-leanpub {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-sellsy {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-shirtsinbulk {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-simplybuilt {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-skyatlas {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-diamond {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-diamond:before {\n  content: \"\\f3a5\";\n}\n\n.fa.fa-transgender:before {\n  content: \"\\f224\";\n}\n\n.fa.fa-intersex:before {\n  content: \"\\f224\";\n}\n\n.fa.fa-transgender-alt:before {\n  content: \"\\f225\";\n}\n\n.fa.fa-facebook-official {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-facebook-official:before {\n  content: \"\\f09a\";\n}\n\n.fa.fa-pinterest-p {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-whatsapp {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-hotel:before {\n  content: \"\\f236\";\n}\n\n.fa.fa-viacoin {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-medium {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-y-combinator {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-yc {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-yc:before {\n  content: \"\\f23b\";\n}\n\n.fa.fa-optin-monster {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-opencart {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-expeditedssl {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-battery-4:before {\n  content: \"\\f240\";\n}\n\n.fa.fa-battery:before {\n  content: \"\\f240\";\n}\n\n.fa.fa-battery-3:before {\n  content: \"\\f241\";\n}\n\n.fa.fa-battery-2:before {\n  content: \"\\f242\";\n}\n\n.fa.fa-battery-1:before {\n  content: \"\\f243\";\n}\n\n.fa.fa-battery-0:before {\n  content: \"\\f244\";\n}\n\n.fa.fa-object-group {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-object-ungroup {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-sticky-note-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-sticky-note-o:before {\n  content: \"\\f249\";\n}\n\n.fa.fa-cc-jcb {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-cc-diners-club {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-clone {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hourglass-o:before {\n  content: \"\\f254\";\n}\n\n.fa.fa-hourglass-1:before {\n  content: \"\\f251\";\n}\n\n.fa.fa-hourglass-2:before {\n  content: \"\\f252\";\n}\n\n.fa.fa-hourglass-3:before {\n  content: \"\\f253\";\n}\n\n.fa.fa-hand-rock-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-rock-o:before {\n  content: \"\\f255\";\n}\n\n.fa.fa-hand-grab-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-grab-o:before {\n  content: \"\\f255\";\n}\n\n.fa.fa-hand-paper-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-paper-o:before {\n  content: \"\\f256\";\n}\n\n.fa.fa-hand-stop-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-stop-o:before {\n  content: \"\\f256\";\n}\n\n.fa.fa-hand-scissors-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-scissors-o:before {\n  content: \"\\f257\";\n}\n\n.fa.fa-hand-lizard-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-lizard-o:before {\n  content: \"\\f258\";\n}\n\n.fa.fa-hand-spock-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-spock-o:before {\n  content: \"\\f259\";\n}\n\n.fa.fa-hand-pointer-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-pointer-o:before {\n  content: \"\\f25a\";\n}\n\n.fa.fa-hand-peace-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-hand-peace-o:before {\n  content: \"\\f25b\";\n}\n\n.fa.fa-registered {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-creative-commons {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-gg {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-gg-circle {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-odnoklassniki {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-odnoklassniki-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-odnoklassniki-square:before {\n  content: \"\\f264\";\n}\n\n.fa.fa-get-pocket {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wikipedia-w {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-safari {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-chrome {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-firefox {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-opera {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-internet-explorer {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-television:before {\n  content: \"\\f26c\";\n}\n\n.fa.fa-contao {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-500px {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-amazon {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-calendar-plus-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-calendar-plus-o:before {\n  content: \"\\f271\";\n}\n\n.fa.fa-calendar-minus-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-calendar-minus-o:before {\n  content: \"\\f272\";\n}\n\n.fa.fa-calendar-times-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-calendar-times-o:before {\n  content: \"\\f273\";\n}\n\n.fa.fa-calendar-check-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-calendar-check-o:before {\n  content: \"\\f274\";\n}\n\n.fa.fa-map-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-map-o:before {\n  content: \"\\f279\";\n}\n\n.fa.fa-commenting:before {\n  content: \"\\f4ad\";\n}\n\n.fa.fa-commenting-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-commenting-o:before {\n  content: \"\\f4ad\";\n}\n\n.fa.fa-houzz {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-vimeo {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-vimeo:before {\n  content: \"\\f27d\";\n}\n\n.fa.fa-black-tie {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-fonticons {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-reddit-alien {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-edge {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-credit-card-alt:before {\n  content: \"\\f09d\";\n}\n\n.fa.fa-codiepie {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-modx {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-fort-awesome {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-usb {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-product-hunt {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-mixcloud {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-scribd {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-pause-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-pause-circle-o:before {\n  content: \"\\f28b\";\n}\n\n.fa.fa-stop-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-stop-circle-o:before {\n  content: \"\\f28d\";\n}\n\n.fa.fa-bluetooth {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-bluetooth-b {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-gitlab {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wpbeginner {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wpforms {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-envira {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wheelchair-alt {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wheelchair-alt:before {\n  content: \"\\f368\";\n}\n\n.fa.fa-question-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-question-circle-o:before {\n  content: \"\\f059\";\n}\n\n.fa.fa-volume-control-phone:before {\n  content: \"\\f2a0\";\n}\n\n.fa.fa-asl-interpreting:before {\n  content: \"\\f2a3\";\n}\n\n.fa.fa-deafness:before {\n  content: \"\\f2a4\";\n}\n\n.fa.fa-hard-of-hearing:before {\n  content: \"\\f2a4\";\n}\n\n.fa.fa-glide {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-glide-g {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-signing:before {\n  content: \"\\f2a7\";\n}\n\n.fa.fa-viadeo {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-viadeo-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-viadeo-square:before {\n  content: \"\\f2aa\";\n}\n\n.fa.fa-snapchat {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-snapchat-ghost {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-snapchat-ghost:before {\n  content: \"\\f2ab\";\n}\n\n.fa.fa-snapchat-square {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-snapchat-square:before {\n  content: \"\\f2ad\";\n}\n\n.fa.fa-pied-piper {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-first-order {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-yoast {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-themeisle {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-google-plus-official {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-google-plus-official:before {\n  content: \"\\f2b3\";\n}\n\n.fa.fa-google-plus-circle {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-google-plus-circle:before {\n  content: \"\\f2b3\";\n}\n\n.fa.fa-font-awesome {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-fa {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-fa:before {\n  content: \"\\f2b4\";\n}\n\n.fa.fa-handshake-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-handshake-o:before {\n  content: \"\\f2b5\";\n}\n\n.fa.fa-envelope-open-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-envelope-open-o:before {\n  content: \"\\f2b6\";\n}\n\n.fa.fa-linode {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-address-book-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-address-book-o:before {\n  content: \"\\f2b9\";\n}\n\n.fa.fa-vcard:before {\n  content: \"\\f2bb\";\n}\n\n.fa.fa-address-card-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-address-card-o:before {\n  content: \"\\f2bb\";\n}\n\n.fa.fa-vcard-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-vcard-o:before {\n  content: \"\\f2bb\";\n}\n\n.fa.fa-user-circle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-user-circle-o:before {\n  content: \"\\f2bd\";\n}\n\n.fa.fa-user-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-user-o:before {\n  content: \"\\f007\";\n}\n\n.fa.fa-id-badge {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-drivers-license:before {\n  content: \"\\f2c2\";\n}\n\n.fa.fa-id-card-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-id-card-o:before {\n  content: \"\\f2c2\";\n}\n\n.fa.fa-drivers-license-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-drivers-license-o:before {\n  content: \"\\f2c2\";\n}\n\n.fa.fa-quora {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-free-code-camp {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-telegram {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-thermometer-4:before {\n  content: \"\\f2c7\";\n}\n\n.fa.fa-thermometer:before {\n  content: \"\\f2c7\";\n}\n\n.fa.fa-thermometer-3:before {\n  content: \"\\f2c8\";\n}\n\n.fa.fa-thermometer-2:before {\n  content: \"\\f2c9\";\n}\n\n.fa.fa-thermometer-1:before {\n  content: \"\\f2ca\";\n}\n\n.fa.fa-thermometer-0:before {\n  content: \"\\f2cb\";\n}\n\n.fa.fa-bathtub:before {\n  content: \"\\f2cd\";\n}\n\n.fa.fa-s15:before {\n  content: \"\\f2cd\";\n}\n\n.fa.fa-window-maximize {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-window-restore {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-times-rectangle:before {\n  content: \"\\f410\";\n}\n\n.fa.fa-window-close-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-window-close-o:before {\n  content: \"\\f410\";\n}\n\n.fa.fa-times-rectangle-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-times-rectangle-o:before {\n  content: \"\\f410\";\n}\n\n.fa.fa-bandcamp {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-grav {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-etsy {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-imdb {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-ravelry {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-eercast {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-eercast:before {\n  content: \"\\f2da\";\n}\n\n.fa.fa-snowflake-o {\n  font-family: \"Font Awesome 6 Free\";\n  font-weight: 400;\n}\n\n.fa.fa-snowflake-o:before {\n  content: \"\\f2dc\";\n}\n\n.fa.fa-superpowers {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-wpexplorer {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}\n\n.fa.fa-meetup {\n  font-family: \"Font Awesome 6 Brands\";\n  font-weight: 400;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {

"use strict";


/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/getUrl.js":
/*!********************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/getUrl.js ***!
  \********************************************************/
/***/ ((module) => {

"use strict";


module.exports = function (url, options) {
  if (!options) {
    // eslint-disable-next-line no-param-reassign
    options = {};
  } // eslint-disable-next-line no-underscore-dangle, no-param-reassign


  url = url && url.__esModule ? url.default : url;

  if (typeof url !== "string") {
    return url;
  } // If url is already wrapped in quotes, remove them


  if (/^['"].*['"]$/.test(url)) {
    // eslint-disable-next-line no-param-reassign
    url = url.slice(1, -1);
  }

  if (options.hash) {
    // eslint-disable-next-line no-param-reassign
    url += options.hash;
  } // Should url be wrapped?
  // See https://drafts.csswg.org/css-values-3/#urls


  if (/["'() \t\n]/.test(url) || options.needQuotes) {
    return "\"".concat(url.replace(/"/g, '\\"').replace(/\n/g, "\\n"), "\"");
  }

  return url;
};

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.ttf":
/*!*******************************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.ttf ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("/fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.ttf?f9ee61fab3c11e2f3ed358f7f7e08fd1");

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.woff2":
/*!*********************************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.woff2 ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("/fonts/vendor/@fortawesome/fontawesome-free/webfa-brands-400.woff2?e1a247a5ef41e1975742ccac2bcdd2b3");

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.ttf":
/*!********************************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.ttf ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("/fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.ttf?abf801b7acb6705a15adbe198ec6b118");

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2":
/*!**********************************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2 ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("/fonts/vendor/@fortawesome/fontawesome-free/webfa-regular-400.woff2?639d2000c1ece92eaec8800924b6a0dd");

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.ttf":
/*!******************************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.ttf ***!
  \******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("/fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.ttf?b48ad290d0335879a92bb6a7e8e08976");

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.woff2":
/*!********************************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.woff2 ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ("/fonts/vendor/@fortawesome/fontawesome-free/webfa-solid-900.woff2?66104b766c3d0462b3c5a310ce92e1aa");

/***/ }),

/***/ "./node_modules/just-extend/index.esm.js":
/*!***********************************************!*\
  !*** ./node_modules/just-extend/index.esm.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ objectExtend)
/* harmony export */ });
var objectExtend = extend;

/*
  var obj = {a: 3, b: 5};
  extend(obj, {a: 4, c: 8}); // {a: 4, b: 5, c: 8}
  obj; // {a: 4, b: 5, c: 8}

  var obj = {a: 3, b: 5};
  extend({}, obj, {a: 4, c: 8}); // {a: 4, b: 5, c: 8}
  obj; // {a: 3, b: 5}

  var arr = [1, 2, 3];
  var obj = {a: 3, b: 5};
  extend(obj, {c: arr}); // {a: 3, b: 5, c: [1, 2, 3]}
  arr.push(4);
  obj; // {a: 3, b: 5, c: [1, 2, 3, 4]}

  var arr = [1, 2, 3];
  var obj = {a: 3, b: 5};
  extend(true, obj, {c: arr}); // {a: 3, b: 5, c: [1, 2, 3]}
  arr.push(4);
  obj; // {a: 3, b: 5, c: [1, 2, 3]}

  extend({a: 4, b: 5}); // {a: 4, b: 5}
  extend({a: 4, b: 5}, 3); {a: 4, b: 5}
  extend({a: 4, b: 5}, true); {a: 4, b: 5}
  extend('hello', {a: 4, b: 5}); // throws
  extend(3, {a: 4, b: 5}); // throws
*/

function extend(/* [deep], obj1, obj2, [objn] */) {
  var args = [].slice.call(arguments);
  var deep = false;
  if (typeof args[0] == 'boolean') {
    deep = args.shift();
  }
  var result = args[0];
  if (isUnextendable(result)) {
    throw new Error('extendee must be an object');
  }
  var extenders = args.slice(1);
  var len = extenders.length;
  for (var i = 0; i < len; i++) {
    var extender = extenders[i];
    for (var key in extender) {
      if (Object.prototype.hasOwnProperty.call(extender, key)) {
        var value = extender[key];
        if (deep && isCloneable(value)) {
          var base = Array.isArray(value) ? [] : {};
          result[key] = extend(
            true,
            Object.prototype.hasOwnProperty.call(result, key) && !isUnextendable(result[key])
              ? result[key]
              : base,
            value
          );
        } else {
          result[key] = value;
        }
      }
    }
  }
  return result;
}

function isCloneable(obj) {
  return Array.isArray(obj) || {}.toString.call(obj) == '[object Object]';
}

function isUnextendable(val) {
  return !val || (typeof val != 'object' && typeof val != 'function');
}




/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/scss/brands.scss":
/*!*********************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/scss/brands.scss ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_brands_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!../../../postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!../../../sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./brands.scss */ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/brands.scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_brands_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_brands_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss":
/*!**************************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_fontawesome_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!../../../postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!../../../sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./fontawesome.scss */ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/fontawesome.scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_fontawesome_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_fontawesome_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/scss/regular.scss":
/*!**********************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/scss/regular.scss ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_regular_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!../../../postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!../../../sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./regular.scss */ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/regular.scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_regular_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_regular_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/scss/solid.scss":
/*!********************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/scss/solid.scss ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_solid_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!../../../postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!../../../sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./solid.scss */ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/solid.scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_solid_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_solid_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/@fortawesome/fontawesome-free/scss/v4-shims.scss":
/*!***********************************************************************!*\
  !*** ./node_modules/@fortawesome/fontawesome-free/scss/v4-shims.scss ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_v4_shims_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!../../../postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!../../../sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./v4-shims.scss */ "./node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[1]!./node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[2]!./node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[7].oneOf[1].use[3]!./node_modules/@fortawesome/fontawesome-free/scss/v4-shims.scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_v4_shims_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_css_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_1_postcss_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_2_sass_loader_dist_cjs_js_ruleSet_1_rules_7_oneOf_1_use_3_v4_shims_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ "./node_modules/sweetalert2/dist/sweetalert2.all.js":
/*!**********************************************************!*\
  !*** ./node_modules/sweetalert2/dist/sweetalert2.all.js ***!
  \**********************************************************/
/***/ (function(module) {

/*!
* sweetalert2 v11.6.5
* Released under the MIT License.
*/
(function (global, factory) {
   true ? module.exports = factory() :
  0;
})(this, (function () { 'use strict';

  /**
   * This module contains `WeakMap`s for each effectively-"private  property" that a `Swal` has.
   * For example, to set the private property "foo" of `this` to "bar", you can `privateProps.foo.set(this, 'bar')`
   * This is the approach that Babel will probably take to implement private methods/fields
   *   https://github.com/tc39/proposal-private-methods
   *   https://github.com/babel/babel/pull/7555
   * Once we have the changes from that PR in Babel, and our core class fits reasonable in *one module*
   *   then we can use that language feature.
   */

  var privateProps = {
    awaitingPromise: new WeakMap(),
    promise: new WeakMap(),
    innerParams: new WeakMap(),
    domCache: new WeakMap()
  };

  const swalPrefix = 'swal2-';

  /**
   * @param {string[]} items
   * @returns {object}
   */
  const prefix = items => {
    const result = {};
    for (const i in items) {
      result[items[i]] = swalPrefix + items[i];
    }
    return result;
  };
  const swalClasses = prefix(['container', 'shown', 'height-auto', 'iosfix', 'popup', 'modal', 'no-backdrop', 'no-transition', 'toast', 'toast-shown', 'show', 'hide', 'close', 'title', 'html-container', 'actions', 'confirm', 'deny', 'cancel', 'default-outline', 'footer', 'icon', 'icon-content', 'image', 'input', 'file', 'range', 'select', 'radio', 'checkbox', 'label', 'textarea', 'inputerror', 'input-label', 'validation-message', 'progress-steps', 'active-progress-step', 'progress-step', 'progress-step-line', 'loader', 'loading', 'styled', 'top', 'top-start', 'top-end', 'top-left', 'top-right', 'center', 'center-start', 'center-end', 'center-left', 'center-right', 'bottom', 'bottom-start', 'bottom-end', 'bottom-left', 'bottom-right', 'grow-row', 'grow-column', 'grow-fullscreen', 'rtl', 'timer-progress-bar', 'timer-progress-bar-container', 'scrollbar-measure', 'icon-success', 'icon-warning', 'icon-info', 'icon-question', 'icon-error', 'no-war']);
  const iconTypes = prefix(['success', 'warning', 'info', 'question', 'error']);

  const consolePrefix = 'SweetAlert2:';

  /**
   * Filter the unique values into a new array
   *
   * @param {Array} arr
   * @returns {Array}
   */
  const uniqueArray = arr => {
    const result = [];
    for (let i = 0; i < arr.length; i++) {
      if (result.indexOf(arr[i]) === -1) {
        result.push(arr[i]);
      }
    }
    return result;
  };

  /**
   * Capitalize the first letter of a string
   *
   * @param {string} str
   * @returns {string}
   */
  const capitalizeFirstLetter = str => str.charAt(0).toUpperCase() + str.slice(1);

  /**
   * Standardize console warnings
   *
   * @param {string | Array} message
   */
  const warn = message => {
    console.warn(`${consolePrefix} ${typeof message === 'object' ? message.join(' ') : message}`);
  };

  /**
   * Standardize console errors
   *
   * @param {string} message
   */
  const error = message => {
    console.error(`${consolePrefix} ${message}`);
  };

  /**
   * Private global state for `warnOnce`
   *
   * @type {Array}
   * @private
   */
  const previousWarnOnceMessages = [];

  /**
   * Show a console warning, but only if it hasn't already been shown
   *
   * @param {string} message
   */
  const warnOnce = message => {
    if (!previousWarnOnceMessages.includes(message)) {
      previousWarnOnceMessages.push(message);
      warn(message);
    }
  };

  /**
   * Show a one-time console warning about deprecated params/methods
   *
   * @param {string} deprecatedParam
   * @param {string} useInstead
   */
  const warnAboutDeprecation = (deprecatedParam, useInstead) => {
    warnOnce(`"${deprecatedParam}" is deprecated and will be removed in the next major release. Please use "${useInstead}" instead.`);
  };

  /**
   * If `arg` is a function, call it (with no arguments or context) and return the result.
   * Otherwise, just pass the value through
   *
   * @param {Function | any} arg
   * @returns {any}
   */
  const callIfFunction = arg => typeof arg === 'function' ? arg() : arg;

  /**
   * @param {any} arg
   * @returns {boolean}
   */
  const hasToPromiseFn = arg => arg && typeof arg.toPromise === 'function';

  /**
   * @param {any} arg
   * @returns {Promise}
   */
  const asPromise = arg => hasToPromiseFn(arg) ? arg.toPromise() : Promise.resolve(arg);

  /**
   * @param {any} arg
   * @returns {boolean}
   */
  const isPromise = arg => arg && Promise.resolve(arg) === arg;

  /**
   * Gets the popup container which contains the backdrop and the popup itself.
   *
   * @returns {HTMLElement | null}
   */
  const getContainer = () => document.body.querySelector(`.${swalClasses.container}`);

  /**
   * @param {string} selectorString
   * @returns {HTMLElement | null}
   */
  const elementBySelector = selectorString => {
    const container = getContainer();
    return container ? container.querySelector(selectorString) : null;
  };

  /**
   * @param {string} className
   * @returns {HTMLElement | null}
   */
  const elementByClass = className => {
    return elementBySelector(`.${className}`);
  };

  /**
   * @returns {HTMLElement | null}
   */
  const getPopup = () => elementByClass(swalClasses.popup);

  /**
   * @returns {HTMLElement | null}
   */
  const getIcon = () => elementByClass(swalClasses.icon);

  /**
   * @returns {HTMLElement | null}
   */
  const getIconContent = () => elementByClass(swalClasses['icon-content']);

  /**
   * @returns {HTMLElement | null}
   */
  const getTitle = () => elementByClass(swalClasses.title);

  /**
   * @returns {HTMLElement | null}
   */
  const getHtmlContainer = () => elementByClass(swalClasses['html-container']);

  /**
   * @returns {HTMLElement | null}
   */
  const getImage = () => elementByClass(swalClasses.image);

  /**
   * @returns {HTMLElement | null}
   */
  const getProgressSteps$1 = () => elementByClass(swalClasses['progress-steps']);

  /**
   * @returns {HTMLElement | null}
   */
  const getValidationMessage = () => elementByClass(swalClasses['validation-message']);

  /**
   * @returns {HTMLElement | null}
   */
  const getConfirmButton = () => elementBySelector(`.${swalClasses.actions} .${swalClasses.confirm}`);

  /**
   * @returns {HTMLElement | null}
   */
  const getDenyButton = () => elementBySelector(`.${swalClasses.actions} .${swalClasses.deny}`);

  /**
   * @returns {HTMLElement | null}
   */
  const getInputLabel = () => elementByClass(swalClasses['input-label']);

  /**
   * @returns {HTMLElement | null}
   */
  const getLoader = () => elementBySelector(`.${swalClasses.loader}`);

  /**
   * @returns {HTMLElement | null}
   */
  const getCancelButton = () => elementBySelector(`.${swalClasses.actions} .${swalClasses.cancel}`);

  /**
   * @returns {HTMLElement | null}
   */
  const getActions = () => elementByClass(swalClasses.actions);

  /**
   * @returns {HTMLElement | null}
   */
  const getFooter = () => elementByClass(swalClasses.footer);

  /**
   * @returns {HTMLElement | null}
   */
  const getTimerProgressBar = () => elementByClass(swalClasses['timer-progress-bar']);

  /**
   * @returns {HTMLElement | null}
   */
  const getCloseButton = () => elementByClass(swalClasses.close);

  // https://github.com/jkup/focusable/blob/master/index.js
  const focusable = `
  a[href],
  area[href],
  input:not([disabled]),
  select:not([disabled]),
  textarea:not([disabled]),
  button:not([disabled]),
  iframe,
  object,
  embed,
  [tabindex="0"],
  [contenteditable],
  audio[controls],
  video[controls],
  summary
`;
  /**
   * @returns {HTMLElement[]}
   */
  const getFocusableElements = () => {
    const focusableElementsWithTabindex = Array.from(getPopup().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])'))
    // sort according to tabindex
    .sort((a, b) => {
      const tabindexA = parseInt(a.getAttribute('tabindex'));
      const tabindexB = parseInt(b.getAttribute('tabindex'));
      if (tabindexA > tabindexB) {
        return 1;
      } else if (tabindexA < tabindexB) {
        return -1;
      }
      return 0;
    });
    const otherFocusableElements = Array.from(getPopup().querySelectorAll(focusable)).filter(el => el.getAttribute('tabindex') !== '-1');
    return uniqueArray(focusableElementsWithTabindex.concat(otherFocusableElements)).filter(el => isVisible$1(el));
  };

  /**
   * @returns {boolean}
   */
  const isModal = () => {
    return hasClass(document.body, swalClasses.shown) && !hasClass(document.body, swalClasses['toast-shown']) && !hasClass(document.body, swalClasses['no-backdrop']);
  };

  /**
   * @returns {boolean}
   */
  const isToast = () => {
    return getPopup() && hasClass(getPopup(), swalClasses.toast);
  };

  /**
   * @returns {boolean}
   */
  const isLoading = () => {
    return getPopup().hasAttribute('data-loading');
  };

  // Remember state in cases where opening and handling a modal will fiddle with it.
  const states = {
    previousBodyPadding: null
  };

  /**
   * Securely set innerHTML of an element
   * https://github.com/sweetalert2/sweetalert2/issues/1926
   *
   * @param {HTMLElement} elem
   * @param {string} html
   */
  const setInnerHtml = (elem, html) => {
    elem.textContent = '';
    if (html) {
      const parser = new DOMParser();
      const parsed = parser.parseFromString(html, `text/html`);
      Array.from(parsed.querySelector('head').childNodes).forEach(child => {
        elem.appendChild(child);
      });
      Array.from(parsed.querySelector('body').childNodes).forEach(child => {
        if (child instanceof HTMLVideoElement || child instanceof HTMLAudioElement) {
          elem.appendChild(child.cloneNode(true)); // https://github.com/sweetalert2/sweetalert2/issues/2507
        } else {
          elem.appendChild(child);
        }
      });
    }
  };

  /**
   * @param {HTMLElement} elem
   * @param {string} className
   * @returns {boolean}
   */
  const hasClass = (elem, className) => {
    if (!className) {
      return false;
    }
    const classList = className.split(/\s+/);
    for (let i = 0; i < classList.length; i++) {
      if (!elem.classList.contains(classList[i])) {
        return false;
      }
    }
    return true;
  };

  /**
   * @param {HTMLElement} elem
   * @param {SweetAlertOptions} params
   */
  const removeCustomClasses = (elem, params) => {
    Array.from(elem.classList).forEach(className => {
      if (!Object.values(swalClasses).includes(className) && !Object.values(iconTypes).includes(className) && !Object.values(params.showClass).includes(className)) {
        elem.classList.remove(className);
      }
    });
  };

  /**
   * @param {HTMLElement} elem
   * @param {SweetAlertOptions} params
   * @param {string} className
   */
  const applyCustomClass = (elem, params, className) => {
    removeCustomClasses(elem, params);
    if (params.customClass && params.customClass[className]) {
      if (typeof params.customClass[className] !== 'string' && !params.customClass[className].forEach) {
        warn(`Invalid type of customClass.${className}! Expected string or iterable object, got "${typeof params.customClass[className]}"`);
        return;
      }
      addClass(elem, params.customClass[className]);
    }
  };

  /**
   * @param {HTMLElement} popup
   * @param {import('./renderers/renderInput').InputClass} inputClass
   * @returns {HTMLInputElement | null}
   */
  const getInput$1 = (popup, inputClass) => {
    if (!inputClass) {
      return null;
    }
    switch (inputClass) {
      case 'select':
      case 'textarea':
      case 'file':
        return popup.querySelector(`.${swalClasses.popup} > .${swalClasses[inputClass]}`);
      case 'checkbox':
        return popup.querySelector(`.${swalClasses.popup} > .${swalClasses.checkbox} input`);
      case 'radio':
        return popup.querySelector(`.${swalClasses.popup} > .${swalClasses.radio} input:checked`) || popup.querySelector(`.${swalClasses.popup} > .${swalClasses.radio} input:first-child`);
      case 'range':
        return popup.querySelector(`.${swalClasses.popup} > .${swalClasses.range} input`);
      default:
        return popup.querySelector(`.${swalClasses.popup} > .${swalClasses.input}`);
    }
  };

  /**
   * @param {HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement} input
   */
  const focusInput = input => {
    input.focus();

    // place cursor at end of text in text input
    if (input.type !== 'file') {
      // http://stackoverflow.com/a/2345915
      const val = input.value;
      input.value = '';
      input.value = val;
    }
  };

  /**
   * @param {HTMLElement | HTMLElement[] | null} target
   * @param {string | string[] | readonly string[]} classList
   * @param {boolean} condition
   */
  const toggleClass = (target, classList, condition) => {
    if (!target || !classList) {
      return;
    }
    if (typeof classList === 'string') {
      classList = classList.split(/\s+/).filter(Boolean);
    }
    classList.forEach(className => {
      if (Array.isArray(target)) {
        target.forEach(elem => {
          condition ? elem.classList.add(className) : elem.classList.remove(className);
        });
      } else {
        condition ? target.classList.add(className) : target.classList.remove(className);
      }
    });
  };

  /**
   * @param {HTMLElement | HTMLElement[] | null} target
   * @param {string | string[] | readonly string[]} classList
   */
  const addClass = (target, classList) => {
    toggleClass(target, classList, true);
  };

  /**
   * @param {HTMLElement | HTMLElement[] | null} target
   * @param {string | string[] | readonly string[]} classList
   */
  const removeClass = (target, classList) => {
    toggleClass(target, classList, false);
  };

  /**
   * Get direct child of an element by class name
   *
   * @param {HTMLElement} elem
   * @param {string} className
   * @returns {HTMLElement | null}
   */
  const getDirectChildByClass = (elem, className) => {
    const children = Array.from(elem.children);
    for (let i = 0; i < children.length; i++) {
      const child = children[i];
      if (child instanceof HTMLElement && hasClass(child, className)) {
        return child;
      }
    }
  };

  /**
   * @param {HTMLElement} elem
   * @param {string} property
   * @param {*} value
   */
  const applyNumericalStyle = (elem, property, value) => {
    if (value === `${parseInt(value)}`) {
      value = parseInt(value);
    }
    if (value || parseInt(value) === 0) {
      elem.style[property] = typeof value === 'number' ? `${value}px` : value;
    } else {
      elem.style.removeProperty(property);
    }
  };

  /**
   * @param {HTMLElement} elem
   * @param {string} display
   */
  const show = function (elem) {
    let display = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'flex';
    elem.style.display = display;
  };

  /**
   * @param {HTMLElement} elem
   */
  const hide = elem => {
    elem.style.display = 'none';
  };

  /**
   * @param {HTMLElement} parent
   * @param {string} selector
   * @param {string} property
   * @param {string} value
   */
  const setStyle = (parent, selector, property, value) => {
    /** @type {HTMLElement} */
    const el = parent.querySelector(selector);
    if (el) {
      el.style[property] = value;
    }
  };

  /**
   * @param {HTMLElement} elem
   * @param {any} condition
   * @param {string} display
   */
  const toggle = function (elem, condition) {
    let display = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'flex';
    condition ? show(elem, display) : hide(elem);
  };

  /**
   * borrowed from jquery $(elem).is(':visible') implementation
   *
   * @param {HTMLElement} elem
   * @returns {boolean}
   */
  const isVisible$1 = elem => !!(elem && (elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length));

  /**
   * @returns {boolean}
   */
  const allButtonsAreHidden = () => !isVisible$1(getConfirmButton()) && !isVisible$1(getDenyButton()) && !isVisible$1(getCancelButton());

  /**
   * @param {HTMLElement} elem
   * @returns {boolean}
   */
  const isScrollable = elem => !!(elem.scrollHeight > elem.clientHeight);

  /**
   * borrowed from https://stackoverflow.com/a/46352119
   *
   * @param {HTMLElement} elem
   * @returns {boolean}
   */
  const hasCssAnimation = elem => {
    const style = window.getComputedStyle(elem);
    const animDuration = parseFloat(style.getPropertyValue('animation-duration') || '0');
    const transDuration = parseFloat(style.getPropertyValue('transition-duration') || '0');
    return animDuration > 0 || transDuration > 0;
  };

  /**
   * @param {number} timer
   * @param {boolean} reset
   */
  const animateTimerProgressBar = function (timer) {
    let reset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    const timerProgressBar = getTimerProgressBar();
    if (isVisible$1(timerProgressBar)) {
      if (reset) {
        timerProgressBar.style.transition = 'none';
        timerProgressBar.style.width = '100%';
      }
      setTimeout(() => {
        timerProgressBar.style.transition = `width ${timer / 1000}s linear`;
        timerProgressBar.style.width = '0%';
      }, 10);
    }
  };
  const stopTimerProgressBar = () => {
    const timerProgressBar = getTimerProgressBar();
    const timerProgressBarWidth = parseInt(window.getComputedStyle(timerProgressBar).width);
    timerProgressBar.style.removeProperty('transition');
    timerProgressBar.style.width = '100%';
    const timerProgressBarFullWidth = parseInt(window.getComputedStyle(timerProgressBar).width);
    const timerProgressBarPercent = timerProgressBarWidth / timerProgressBarFullWidth * 100;
    timerProgressBar.style.removeProperty('transition');
    timerProgressBar.style.width = `${timerProgressBarPercent}%`;
  };

  const RESTORE_FOCUS_TIMEOUT = 100;

  /** @type {GlobalState} */
  const globalState = {};
  const focusPreviousActiveElement = () => {
    if (globalState.previousActiveElement instanceof HTMLElement) {
      globalState.previousActiveElement.focus();
      globalState.previousActiveElement = null;
    } else if (document.body) {
      document.body.focus();
    }
  };

  /**
   * Restore previous active (focused) element
   *
   * @param {boolean} returnFocus
   * @returns {Promise}
   */
  const restoreActiveElement = returnFocus => {
    return new Promise(resolve => {
      if (!returnFocus) {
        return resolve();
      }
      const x = window.scrollX;
      const y = window.scrollY;
      globalState.restoreFocusTimeout = setTimeout(() => {
        focusPreviousActiveElement();
        resolve();
      }, RESTORE_FOCUS_TIMEOUT); // issues/900

      window.scrollTo(x, y);
    });
  };

  /**
   * Detect Node env
   *
   * @returns {boolean}
   */
  const isNodeEnv = () => typeof window === 'undefined' || typeof document === 'undefined';

  const sweetHTML = `
 <div aria-labelledby="${swalClasses.title}" aria-describedby="${swalClasses['html-container']}" class="${swalClasses.popup}" tabindex="-1">
   <button type="button" class="${swalClasses.close}"></button>
   <ul class="${swalClasses['progress-steps']}"></ul>
   <div class="${swalClasses.icon}"></div>
   <img class="${swalClasses.image}" />
   <h2 class="${swalClasses.title}" id="${swalClasses.title}"></h2>
   <div class="${swalClasses['html-container']}" id="${swalClasses['html-container']}"></div>
   <input class="${swalClasses.input}" />
   <input type="file" class="${swalClasses.file}" />
   <div class="${swalClasses.range}">
     <input type="range" />
     <output></output>
   </div>
   <select class="${swalClasses.select}"></select>
   <div class="${swalClasses.radio}"></div>
   <label for="${swalClasses.checkbox}" class="${swalClasses.checkbox}">
     <input type="checkbox" />
     <span class="${swalClasses.label}"></span>
   </label>
   <textarea class="${swalClasses.textarea}"></textarea>
   <div class="${swalClasses['validation-message']}" id="${swalClasses['validation-message']}"></div>
   <div class="${swalClasses.actions}">
     <div class="${swalClasses.loader}"></div>
     <button type="button" class="${swalClasses.confirm}"></button>
     <button type="button" class="${swalClasses.deny}"></button>
     <button type="button" class="${swalClasses.cancel}"></button>
   </div>
   <div class="${swalClasses.footer}"></div>
   <div class="${swalClasses['timer-progress-bar-container']}">
     <div class="${swalClasses['timer-progress-bar']}"></div>
   </div>
 </div>
`.replace(/(^|\n)\s*/g, '');

  /**
   * @returns {boolean}
   */
  const resetOldContainer = () => {
    const oldContainer = getContainer();
    if (!oldContainer) {
      return false;
    }
    oldContainer.remove();
    removeClass([document.documentElement, document.body], [swalClasses['no-backdrop'], swalClasses['toast-shown'], swalClasses['has-column']]);
    return true;
  };
  const resetValidationMessage$1 = () => {
    globalState.currentInstance.resetValidationMessage();
  };
  const addInputChangeListeners = () => {
    const popup = getPopup();
    const input = getDirectChildByClass(popup, swalClasses.input);
    const file = getDirectChildByClass(popup, swalClasses.file);
    /** @type {HTMLInputElement} */
    const range = popup.querySelector(`.${swalClasses.range} input`);
    /** @type {HTMLOutputElement} */
    const rangeOutput = popup.querySelector(`.${swalClasses.range} output`);
    const select = getDirectChildByClass(popup, swalClasses.select);
    /** @type {HTMLInputElement} */
    const checkbox = popup.querySelector(`.${swalClasses.checkbox} input`);
    const textarea = getDirectChildByClass(popup, swalClasses.textarea);
    input.oninput = resetValidationMessage$1;
    file.onchange = resetValidationMessage$1;
    select.onchange = resetValidationMessage$1;
    checkbox.onchange = resetValidationMessage$1;
    textarea.oninput = resetValidationMessage$1;
    range.oninput = () => {
      resetValidationMessage$1();
      rangeOutput.value = range.value;
    };
    range.onchange = () => {
      resetValidationMessage$1();
      rangeOutput.value = range.value;
    };
  };

  /**
   * @param {string | HTMLElement} target
   * @returns {HTMLElement}
   */
  const getTarget = target => typeof target === 'string' ? document.querySelector(target) : target;

  /**
   * @param {SweetAlertOptions} params
   */
  const setupAccessibility = params => {
    const popup = getPopup();
    popup.setAttribute('role', params.toast ? 'alert' : 'dialog');
    popup.setAttribute('aria-live', params.toast ? 'polite' : 'assertive');
    if (!params.toast) {
      popup.setAttribute('aria-modal', 'true');
    }
  };

  /**
   * @param {HTMLElement} targetElement
   */
  const setupRTL = targetElement => {
    if (window.getComputedStyle(targetElement).direction === 'rtl') {
      addClass(getContainer(), swalClasses.rtl);
    }
  };

  /**
   * Add modal + backdrop + no-war message for Russians to DOM
   *
   * @param {SweetAlertOptions} params
   */
  const init = params => {
    // Clean up the old popup container if it exists
    const oldContainerExisted = resetOldContainer();

    /* istanbul ignore if */
    if (isNodeEnv()) {
      error('SweetAlert2 requires document to initialize');
      return;
    }
    const container = document.createElement('div');
    container.className = swalClasses.container;
    if (oldContainerExisted) {
      addClass(container, swalClasses['no-transition']);
    }
    setInnerHtml(container, sweetHTML);
    const targetElement = getTarget(params.target);
    targetElement.appendChild(container);
    setupAccessibility(params);
    setupRTL(targetElement);
    addInputChangeListeners();
  };

  /**
   * @param {HTMLElement | object | string} param
   * @param {HTMLElement} target
   */
  const parseHtmlToContainer = (param, target) => {
    // DOM element
    if (param instanceof HTMLElement) {
      target.appendChild(param);
    }

    // Object
    else if (typeof param === 'object') {
      handleObject(param, target);
    }

    // Plain string
    else if (param) {
      setInnerHtml(target, param);
    }
  };

  /**
   * @param {object} param
   * @param {HTMLElement} target
   */
  const handleObject = (param, target) => {
    // JQuery element(s)
    if (param.jquery) {
      handleJqueryElem(target, param);
    }

    // For other objects use their string representation
    else {
      setInnerHtml(target, param.toString());
    }
  };

  /**
   * @param {HTMLElement} target
   * @param {HTMLElement} elem
   */
  const handleJqueryElem = (target, elem) => {
    target.textContent = '';
    if (0 in elem) {
      for (let i = 0; (i in elem); i++) {
        target.appendChild(elem[i].cloneNode(true));
      }
    } else {
      target.appendChild(elem.cloneNode(true));
    }
  };

  /**
   * @returns {'webkitAnimationEnd' | 'animationend' | false}
   */
  const animationEndEvent = (() => {
    // Prevent run in Node env
    /* istanbul ignore if */
    if (isNodeEnv()) {
      return false;
    }
    const testEl = document.createElement('div');
    const transEndEventNames = {
      WebkitAnimation: 'webkitAnimationEnd',
      // Chrome, Safari and Opera
      animation: 'animationend' // Standard syntax
    };

    for (const i in transEndEventNames) {
      if (Object.prototype.hasOwnProperty.call(transEndEventNames, i) && typeof testEl.style[i] !== 'undefined') {
        return transEndEventNames[i];
      }
    }
    return false;
  })();

  /**
   * Measure scrollbar width for padding body during modal show/hide
   * https://github.com/twbs/bootstrap/blob/master/js/src/modal.js
   *
   * @returns {number}
   */
  const measureScrollbar = () => {
    const scrollDiv = document.createElement('div');
    scrollDiv.className = swalClasses['scrollbar-measure'];
    document.body.appendChild(scrollDiv);
    const scrollbarWidth = scrollDiv.getBoundingClientRect().width - scrollDiv.clientWidth;
    document.body.removeChild(scrollDiv);
    return scrollbarWidth;
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderActions = (instance, params) => {
    const actions = getActions();
    const loader = getLoader();

    // Actions (buttons) wrapper
    if (!params.showConfirmButton && !params.showDenyButton && !params.showCancelButton) {
      hide(actions);
    } else {
      show(actions);
    }

    // Custom class
    applyCustomClass(actions, params, 'actions');

    // Render all the buttons
    renderButtons(actions, loader, params);

    // Loader
    setInnerHtml(loader, params.loaderHtml);
    applyCustomClass(loader, params, 'loader');
  };

  /**
   * @param {HTMLElement} actions
   * @param {HTMLElement} loader
   * @param {SweetAlertOptions} params
   */
  function renderButtons(actions, loader, params) {
    const confirmButton = getConfirmButton();
    const denyButton = getDenyButton();
    const cancelButton = getCancelButton();

    // Render buttons
    renderButton(confirmButton, 'confirm', params);
    renderButton(denyButton, 'deny', params);
    renderButton(cancelButton, 'cancel', params);
    handleButtonsStyling(confirmButton, denyButton, cancelButton, params);
    if (params.reverseButtons) {
      if (params.toast) {
        actions.insertBefore(cancelButton, confirmButton);
        actions.insertBefore(denyButton, confirmButton);
      } else {
        actions.insertBefore(cancelButton, loader);
        actions.insertBefore(denyButton, loader);
        actions.insertBefore(confirmButton, loader);
      }
    }
  }

  /**
   * @param {HTMLElement} confirmButton
   * @param {HTMLElement} denyButton
   * @param {HTMLElement} cancelButton
   * @param {SweetAlertOptions} params
   */
  function handleButtonsStyling(confirmButton, denyButton, cancelButton, params) {
    if (!params.buttonsStyling) {
      removeClass([confirmButton, denyButton, cancelButton], swalClasses.styled);
      return;
    }
    addClass([confirmButton, denyButton, cancelButton], swalClasses.styled);

    // Buttons background colors
    if (params.confirmButtonColor) {
      confirmButton.style.backgroundColor = params.confirmButtonColor;
      addClass(confirmButton, swalClasses['default-outline']);
    }
    if (params.denyButtonColor) {
      denyButton.style.backgroundColor = params.denyButtonColor;
      addClass(denyButton, swalClasses['default-outline']);
    }
    if (params.cancelButtonColor) {
      cancelButton.style.backgroundColor = params.cancelButtonColor;
      addClass(cancelButton, swalClasses['default-outline']);
    }
  }

  /**
   * @param {HTMLElement} button
   * @param {'confirm' | 'deny' | 'cancel'} buttonType
   * @param {SweetAlertOptions} params
   */
  function renderButton(button, buttonType, params) {
    toggle(button, params[`show${capitalizeFirstLetter(buttonType)}Button`], 'inline-block');
    setInnerHtml(button, params[`${buttonType}ButtonText`]); // Set caption text
    button.setAttribute('aria-label', params[`${buttonType}ButtonAriaLabel`]); // ARIA label

    // Add buttons custom classes
    button.className = swalClasses[buttonType];
    applyCustomClass(button, params, `${buttonType}Button`);
    addClass(button, params[`${buttonType}ButtonClass`]);
  }

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderCloseButton = (instance, params) => {
    const closeButton = getCloseButton();
    setInnerHtml(closeButton, params.closeButtonHtml);

    // Custom class
    applyCustomClass(closeButton, params, 'closeButton');
    toggle(closeButton, params.showCloseButton);
    closeButton.setAttribute('aria-label', params.closeButtonAriaLabel);
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderContainer = (instance, params) => {
    const container = getContainer();
    if (!container) {
      return;
    }
    handleBackdropParam(container, params.backdrop);
    handlePositionParam(container, params.position);
    handleGrowParam(container, params.grow);

    // Custom class
    applyCustomClass(container, params, 'container');
  };

  /**
   * @param {HTMLElement} container
   * @param {SweetAlertOptions['backdrop']} backdrop
   */
  function handleBackdropParam(container, backdrop) {
    if (typeof backdrop === 'string') {
      container.style.background = backdrop;
    } else if (!backdrop) {
      addClass([document.documentElement, document.body], swalClasses['no-backdrop']);
    }
  }

  /**
   * @param {HTMLElement} container
   * @param {SweetAlertOptions['position']} position
   */
  function handlePositionParam(container, position) {
    if (position in swalClasses) {
      addClass(container, swalClasses[position]);
    } else {
      warn('The "position" parameter is not valid, defaulting to "center"');
      addClass(container, swalClasses.center);
    }
  }

  /**
   * @param {HTMLElement} container
   * @param {SweetAlertOptions['grow']} grow
   */
  function handleGrowParam(container, grow) {
    if (grow && typeof grow === 'string') {
      const growClass = `grow-${grow}`;
      if (growClass in swalClasses) {
        addClass(container, swalClasses[growClass]);
      }
    }
  }

  /// <reference path="../../../../sweetalert2.d.ts"/>

  /** @type {InputClass[]} */
  const inputClasses = ['input', 'file', 'range', 'select', 'radio', 'checkbox', 'textarea'];

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderInput = (instance, params) => {
    const popup = getPopup();
    const innerParams = privateProps.innerParams.get(instance);
    const rerender = !innerParams || params.input !== innerParams.input;
    inputClasses.forEach(inputClass => {
      const inputContainer = getDirectChildByClass(popup, swalClasses[inputClass]);

      // set attributes
      setAttributes(inputClass, params.inputAttributes);

      // set class
      inputContainer.className = swalClasses[inputClass];
      if (rerender) {
        hide(inputContainer);
      }
    });
    if (params.input) {
      if (rerender) {
        showInput(params);
      }
      // set custom class
      setCustomClass(params);
    }
  };

  /**
   * @param {SweetAlertOptions} params
   */
  const showInput = params => {
    if (!renderInputType[params.input]) {
      error(`Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "${params.input}"`);
      return;
    }
    const inputContainer = getInputContainer(params.input);
    const input = renderInputType[params.input](inputContainer, params);
    show(inputContainer);

    // input autofocus
    setTimeout(() => {
      focusInput(input);
    });
  };

  /**
   * @param {HTMLInputElement} input
   */
  const removeAttributes = input => {
    for (let i = 0; i < input.attributes.length; i++) {
      const attrName = input.attributes[i].name;
      if (!['type', 'value', 'style'].includes(attrName)) {
        input.removeAttribute(attrName);
      }
    }
  };

  /**
   * @param {InputClass} inputClass
   * @param {SweetAlertOptions['inputAttributes']} inputAttributes
   */
  const setAttributes = (inputClass, inputAttributes) => {
    const input = getInput$1(getPopup(), inputClass);
    if (!input) {
      return;
    }
    removeAttributes(input);
    for (const attr in inputAttributes) {
      input.setAttribute(attr, inputAttributes[attr]);
    }
  };

  /**
   * @param {SweetAlertOptions} params
   */
  const setCustomClass = params => {
    const inputContainer = getInputContainer(params.input);
    if (typeof params.customClass === 'object') {
      addClass(inputContainer, params.customClass.input);
    }
  };

  /**
   * @param {HTMLInputElement | HTMLTextAreaElement} input
   * @param {SweetAlertOptions} params
   */
  const setInputPlaceholder = (input, params) => {
    if (!input.placeholder || params.inputPlaceholder) {
      input.placeholder = params.inputPlaceholder;
    }
  };

  /**
   * @param {Input} input
   * @param {Input} prependTo
   * @param {SweetAlertOptions} params
   */
  const setInputLabel = (input, prependTo, params) => {
    if (params.inputLabel) {
      input.id = swalClasses.input;
      const label = document.createElement('label');
      const labelClass = swalClasses['input-label'];
      label.setAttribute('for', input.id);
      label.className = labelClass;
      if (typeof params.customClass === 'object') {
        addClass(label, params.customClass.inputLabel);
      }
      label.innerText = params.inputLabel;
      prependTo.insertAdjacentElement('beforebegin', label);
    }
  };

  /**
   * @param {SweetAlertOptions['input']} inputType
   * @returns {HTMLElement}
   */
  const getInputContainer = inputType => {
    return getDirectChildByClass(getPopup(), swalClasses[inputType] || swalClasses.input);
  };

  /**
   * @param {HTMLInputElement | HTMLOutputElement | HTMLTextAreaElement} input
   * @param {SweetAlertOptions['inputValue']} inputValue
   */
  const checkAndSetInputValue = (input, inputValue) => {
    if (['string', 'number'].includes(typeof inputValue)) {
      input.value = `${inputValue}`;
    } else if (!isPromise(inputValue)) {
      warn(`Unexpected type of inputValue! Expected "string", "number" or "Promise", got "${typeof inputValue}"`);
    }
  };

  /** @type {Record<string, (input: Input | HTMLElement, params: SweetAlertOptions) => Input>} */
  const renderInputType = {};

  /**
   * @param {HTMLInputElement} input
   * @param {SweetAlertOptions} params
   * @returns {HTMLInputElement}
   */
  renderInputType.text = renderInputType.email = renderInputType.password = renderInputType.number = renderInputType.tel = renderInputType.url = (input, params) => {
    checkAndSetInputValue(input, params.inputValue);
    setInputLabel(input, input, params);
    setInputPlaceholder(input, params);
    input.type = params.input;
    return input;
  };

  /**
   * @param {HTMLInputElement} input
   * @param {SweetAlertOptions} params
   * @returns {HTMLInputElement}
   */
  renderInputType.file = (input, params) => {
    setInputLabel(input, input, params);
    setInputPlaceholder(input, params);
    return input;
  };

  /**
   * @param {HTMLInputElement} range
   * @param {SweetAlertOptions} params
   * @returns {HTMLInputElement}
   */
  renderInputType.range = (range, params) => {
    const rangeInput = range.querySelector('input');
    const rangeOutput = range.querySelector('output');
    checkAndSetInputValue(rangeInput, params.inputValue);
    rangeInput.type = params.input;
    checkAndSetInputValue(rangeOutput, params.inputValue);
    setInputLabel(rangeInput, range, params);
    return range;
  };

  /**
   * @param {HTMLSelectElement} select
   * @param {SweetAlertOptions} params
   * @returns {HTMLSelectElement}
   */
  renderInputType.select = (select, params) => {
    select.textContent = '';
    if (params.inputPlaceholder) {
      const placeholder = document.createElement('option');
      setInnerHtml(placeholder, params.inputPlaceholder);
      placeholder.value = '';
      placeholder.disabled = true;
      placeholder.selected = true;
      select.appendChild(placeholder);
    }
    setInputLabel(select, select, params);
    return select;
  };

  /**
   * @param {HTMLInputElement} radio
   * @returns {HTMLInputElement}
   */
  renderInputType.radio = radio => {
    radio.textContent = '';
    return radio;
  };

  /**
   * @param {HTMLLabelElement} checkboxContainer
   * @param {SweetAlertOptions} params
   * @returns {HTMLInputElement}
   */
  renderInputType.checkbox = (checkboxContainer, params) => {
    const checkbox = getInput$1(getPopup(), 'checkbox');
    checkbox.value = '1';
    checkbox.id = swalClasses.checkbox;
    checkbox.checked = Boolean(params.inputValue);
    const label = checkboxContainer.querySelector('span');
    setInnerHtml(label, params.inputPlaceholder);
    return checkbox;
  };

  /**
   * @param {HTMLTextAreaElement} textarea
   * @param {SweetAlertOptions} params
   * @returns {HTMLTextAreaElement}
   */
  renderInputType.textarea = (textarea, params) => {
    checkAndSetInputValue(textarea, params.inputValue);
    setInputPlaceholder(textarea, params);
    setInputLabel(textarea, textarea, params);

    /**
     * @param {HTMLElement} el
     * @returns {number}
     */
    const getMargin = el => parseInt(window.getComputedStyle(el).marginLeft) + parseInt(window.getComputedStyle(el).marginRight);

    // https://github.com/sweetalert2/sweetalert2/issues/2291
    setTimeout(() => {
      // https://github.com/sweetalert2/sweetalert2/issues/1699
      if ('MutationObserver' in window) {
        const initialPopupWidth = parseInt(window.getComputedStyle(getPopup()).width);
        const textareaResizeHandler = () => {
          const textareaWidth = textarea.offsetWidth + getMargin(textarea);
          if (textareaWidth > initialPopupWidth) {
            getPopup().style.width = `${textareaWidth}px`;
          } else {
            getPopup().style.width = null;
          }
        };
        new MutationObserver(textareaResizeHandler).observe(textarea, {
          attributes: true,
          attributeFilter: ['style']
        });
      }
    });
    return textarea;
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderContent = (instance, params) => {
    const htmlContainer = getHtmlContainer();
    applyCustomClass(htmlContainer, params, 'htmlContainer');

    // Content as HTML
    if (params.html) {
      parseHtmlToContainer(params.html, htmlContainer);
      show(htmlContainer, 'block');
    }

    // Content as plain text
    else if (params.text) {
      htmlContainer.textContent = params.text;
      show(htmlContainer, 'block');
    }

    // No content
    else {
      hide(htmlContainer);
    }
    renderInput(instance, params);
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderFooter = (instance, params) => {
    const footer = getFooter();
    toggle(footer, params.footer);
    if (params.footer) {
      parseHtmlToContainer(params.footer, footer);
    }

    // Custom class
    applyCustomClass(footer, params, 'footer');
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderIcon = (instance, params) => {
    const innerParams = privateProps.innerParams.get(instance);
    const icon = getIcon();

    // if the given icon already rendered, apply the styling without re-rendering the icon
    if (innerParams && params.icon === innerParams.icon) {
      // Custom or default content
      setContent(icon, params);
      applyStyles(icon, params);
      return;
    }
    if (!params.icon && !params.iconHtml) {
      hide(icon);
      return;
    }
    if (params.icon && Object.keys(iconTypes).indexOf(params.icon) === -1) {
      error(`Unknown icon! Expected "success", "error", "warning", "info" or "question", got "${params.icon}"`);
      hide(icon);
      return;
    }
    show(icon);

    // Custom or default content
    setContent(icon, params);
    applyStyles(icon, params);

    // Animate icon
    addClass(icon, params.showClass.icon);
  };

  /**
   * @param {HTMLElement} icon
   * @param {SweetAlertOptions} params
   */
  const applyStyles = (icon, params) => {
    for (const iconType in iconTypes) {
      if (params.icon !== iconType) {
        removeClass(icon, iconTypes[iconType]);
      }
    }
    addClass(icon, iconTypes[params.icon]);

    // Icon color
    setColor(icon, params);

    // Success icon background color
    adjustSuccessIconBackgroundColor();

    // Custom class
    applyCustomClass(icon, params, 'icon');
  };

  // Adjust success icon background color to match the popup background color
  const adjustSuccessIconBackgroundColor = () => {
    const popup = getPopup();
    const popupBackgroundColor = window.getComputedStyle(popup).getPropertyValue('background-color');
    /** @type {NodeListOf<HTMLElement>} */
    const successIconParts = popup.querySelectorAll('[class^=swal2-success-circular-line], .swal2-success-fix');
    for (let i = 0; i < successIconParts.length; i++) {
      successIconParts[i].style.backgroundColor = popupBackgroundColor;
    }
  };
  const successIconHtml = `
  <div class="swal2-success-circular-line-left"></div>
  <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
  <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>
  <div class="swal2-success-circular-line-right"></div>
`;
  const errorIconHtml = `
  <span class="swal2-x-mark">
    <span class="swal2-x-mark-line-left"></span>
    <span class="swal2-x-mark-line-right"></span>
  </span>
`;

  /**
   * @param {HTMLElement} icon
   * @param {SweetAlertOptions} params
   */
  const setContent = (icon, params) => {
    let oldContent = icon.innerHTML;
    let newContent;
    if (params.iconHtml) {
      newContent = iconContent(params.iconHtml);
    } else if (params.icon === 'success') {
      newContent = successIconHtml;
      oldContent = oldContent.replace(/ style=".*?"/g, ''); // undo adjustSuccessIconBackgroundColor()
    } else if (params.icon === 'error') {
      newContent = errorIconHtml;
    } else {
      const defaultIconHtml = {
        question: '?',
        warning: '!',
        info: 'i'
      };
      newContent = iconContent(defaultIconHtml[params.icon]);
    }
    if (oldContent.trim() !== newContent.trim()) {
      setInnerHtml(icon, newContent);
    }
  };

  /**
   * @param {HTMLElement} icon
   * @param {SweetAlertOptions} params
   */
  const setColor = (icon, params) => {
    if (!params.iconColor) {
      return;
    }
    icon.style.color = params.iconColor;
    icon.style.borderColor = params.iconColor;
    for (const sel of ['.swal2-success-line-tip', '.swal2-success-line-long', '.swal2-x-mark-line-left', '.swal2-x-mark-line-right']) {
      setStyle(icon, sel, 'backgroundColor', params.iconColor);
    }
    setStyle(icon, '.swal2-success-ring', 'borderColor', params.iconColor);
  };

  /**
   * @param {string} content
   * @returns {string}
   */
  const iconContent = content => `<div class="${swalClasses['icon-content']}">${content}</div>`;

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderImage = (instance, params) => {
    const image = getImage();
    if (!params.imageUrl) {
      hide(image);
      return;
    }
    show(image, '');

    // Src, alt
    image.setAttribute('src', params.imageUrl);
    image.setAttribute('alt', params.imageAlt);

    // Width, height
    applyNumericalStyle(image, 'width', params.imageWidth);
    applyNumericalStyle(image, 'height', params.imageHeight);

    // Class
    image.className = swalClasses.image;
    applyCustomClass(image, params, 'image');
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderPopup = (instance, params) => {
    const container = getContainer();
    const popup = getPopup();

    // Width
    // https://github.com/sweetalert2/sweetalert2/issues/2170
    if (params.toast) {
      applyNumericalStyle(container, 'width', params.width);
      popup.style.width = '100%';
      popup.insertBefore(getLoader(), getIcon());
    } else {
      applyNumericalStyle(popup, 'width', params.width);
    }

    // Padding
    applyNumericalStyle(popup, 'padding', params.padding);

    // Color
    if (params.color) {
      popup.style.color = params.color;
    }

    // Background
    if (params.background) {
      popup.style.background = params.background;
    }
    hide(getValidationMessage());

    // Classes
    addClasses$1(popup, params);
  };

  /**
   * @param {HTMLElement} popup
   * @param {SweetAlertOptions} params
   */
  const addClasses$1 = (popup, params) => {
    // Default Class + showClass when updating Swal.update({})
    popup.className = `${swalClasses.popup} ${isVisible$1(popup) ? params.showClass.popup : ''}`;
    if (params.toast) {
      addClass([document.documentElement, document.body], swalClasses['toast-shown']);
      addClass(popup, swalClasses.toast);
    } else {
      addClass(popup, swalClasses.modal);
    }

    // Custom class
    applyCustomClass(popup, params, 'popup');
    if (typeof params.customClass === 'string') {
      addClass(popup, params.customClass);
    }

    // Icon class (#1842)
    if (params.icon) {
      addClass(popup, swalClasses[`icon-${params.icon}`]);
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderProgressSteps = (instance, params) => {
    const progressStepsContainer = getProgressSteps$1();
    if (!params.progressSteps || params.progressSteps.length === 0) {
      hide(progressStepsContainer);
      return;
    }
    show(progressStepsContainer);
    progressStepsContainer.textContent = '';
    if (params.currentProgressStep >= params.progressSteps.length) {
      warn('Invalid currentProgressStep parameter, it should be less than progressSteps.length ' + '(currentProgressStep like JS arrays starts from 0)');
    }
    params.progressSteps.forEach((step, index) => {
      const stepEl = createStepElement(step);
      progressStepsContainer.appendChild(stepEl);
      if (index === params.currentProgressStep) {
        addClass(stepEl, swalClasses['active-progress-step']);
      }
      if (index !== params.progressSteps.length - 1) {
        const lineEl = createLineElement(params);
        progressStepsContainer.appendChild(lineEl);
      }
    });
  };

  /**
   * @param {string} step
   * @returns {HTMLLIElement}
   */
  const createStepElement = step => {
    const stepEl = document.createElement('li');
    addClass(stepEl, swalClasses['progress-step']);
    setInnerHtml(stepEl, step);
    return stepEl;
  };

  /**
   * @param {SweetAlertOptions} params
   * @returns {HTMLLIElement}
   */
  const createLineElement = params => {
    const lineEl = document.createElement('li');
    addClass(lineEl, swalClasses['progress-step-line']);
    if (params.progressStepsDistance) {
      applyNumericalStyle(lineEl, 'width', params.progressStepsDistance);
    }
    return lineEl;
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const renderTitle = (instance, params) => {
    const title = getTitle();
    toggle(title, params.title || params.titleText, 'block');
    if (params.title) {
      parseHtmlToContainer(params.title, title);
    }
    if (params.titleText) {
      title.innerText = params.titleText;
    }

    // Custom class
    applyCustomClass(title, params, 'title');
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const render = (instance, params) => {
    renderPopup(instance, params);
    renderContainer(instance, params);
    renderProgressSteps(instance, params);
    renderIcon(instance, params);
    renderImage(instance, params);
    renderTitle(instance, params);
    renderCloseButton(instance, params);
    renderContent(instance, params);
    renderActions(instance, params);
    renderFooter(instance, params);
    if (typeof params.didRender === 'function') {
      params.didRender(getPopup());
    }
  };

  /**
   * Hides loader and shows back the button which was hidden by .showLoading()
   */
  function hideLoading() {
    // do nothing if popup is closed
    const innerParams = privateProps.innerParams.get(this);
    if (!innerParams) {
      return;
    }
    const domCache = privateProps.domCache.get(this);
    hide(domCache.loader);
    if (isToast()) {
      if (innerParams.icon) {
        show(getIcon());
      }
    } else {
      showRelatedButton(domCache);
    }
    removeClass([domCache.popup, domCache.actions], swalClasses.loading);
    domCache.popup.removeAttribute('aria-busy');
    domCache.popup.removeAttribute('data-loading');
    domCache.confirmButton.disabled = false;
    domCache.denyButton.disabled = false;
    domCache.cancelButton.disabled = false;
  }
  const showRelatedButton = domCache => {
    const buttonToReplace = domCache.popup.getElementsByClassName(domCache.loader.getAttribute('data-button-to-replace'));
    if (buttonToReplace.length) {
      show(buttonToReplace[0], 'inline-block');
    } else if (allButtonsAreHidden()) {
      hide(domCache.actions);
    }
  };

  /**
   * Gets the input DOM node, this method works with input parameter.
   *
   * @param {SweetAlert2} instance
   * @returns {HTMLElement | null}
   */
  function getInput(instance) {
    const innerParams = privateProps.innerParams.get(instance || this);
    const domCache = privateProps.domCache.get(instance || this);
    if (!domCache) {
      return null;
    }
    return getInput$1(domCache.popup, innerParams.input);
  }

  /*
   * Global function to determine if SweetAlert2 popup is shown
   */
  const isVisible = () => {
    return isVisible$1(getPopup());
  };

  /*
   * Global function to click 'Confirm' button
   */
  const clickConfirm = () => getConfirmButton() && getConfirmButton().click();

  /*
   * Global function to click 'Deny' button
   */
  const clickDeny = () => getDenyButton() && getDenyButton().click();

  /*
   * Global function to click 'Cancel' button
   */
  const clickCancel = () => getCancelButton() && getCancelButton().click();

  const DismissReason = Object.freeze({
    cancel: 'cancel',
    backdrop: 'backdrop',
    close: 'close',
    esc: 'esc',
    timer: 'timer'
  });

  /**
   * @param {GlobalState} globalState
   */
  const removeKeydownHandler = globalState => {
    if (globalState.keydownTarget && globalState.keydownHandlerAdded) {
      globalState.keydownTarget.removeEventListener('keydown', globalState.keydownHandler, {
        capture: globalState.keydownListenerCapture
      });
      globalState.keydownHandlerAdded = false;
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {GlobalState} globalState
   * @param {SweetAlertOptions} innerParams
   * @param {*} dismissWith
   */
  const addKeydownHandler = (instance, globalState, innerParams, dismissWith) => {
    removeKeydownHandler(globalState);
    if (!innerParams.toast) {
      globalState.keydownHandler = e => keydownHandler(instance, e, dismissWith);
      globalState.keydownTarget = innerParams.keydownListenerCapture ? window : getPopup();
      globalState.keydownListenerCapture = innerParams.keydownListenerCapture;
      globalState.keydownTarget.addEventListener('keydown', globalState.keydownHandler, {
        capture: globalState.keydownListenerCapture
      });
      globalState.keydownHandlerAdded = true;
    }
  };

  /**
   * @param {SweetAlertOptions} innerParams
   * @param {number} index
   * @param {number} increment
   */
  const setFocus = (innerParams, index, increment) => {
    const focusableElements = getFocusableElements();
    // search for visible elements and select the next possible match
    if (focusableElements.length) {
      index = index + increment;

      // rollover to first item
      if (index === focusableElements.length) {
        index = 0;

        // go to last item
      } else if (index === -1) {
        index = focusableElements.length - 1;
      }
      return focusableElements[index].focus();
    }
    // no visible focusable elements, focus the popup
    getPopup().focus();
  };
  const arrowKeysNextButton = ['ArrowRight', 'ArrowDown'];
  const arrowKeysPreviousButton = ['ArrowLeft', 'ArrowUp'];

  /**
   * @param {SweetAlert2} instance
   * @param {KeyboardEvent} e
   * @param {function} dismissWith
   */
  const keydownHandler = (instance, e, dismissWith) => {
    const innerParams = privateProps.innerParams.get(instance);
    if (!innerParams) {
      return; // This instance has already been destroyed
    }

    // Ignore keydown during IME composition
    // https://developer.mozilla.org/en-US/docs/Web/API/Document/keydown_event#ignoring_keydown_during_ime_composition
    // https://github.com/sweetalert2/sweetalert2/issues/720
    // https://github.com/sweetalert2/sweetalert2/issues/2406
    if (e.isComposing || e.keyCode === 229) {
      return;
    }
    if (innerParams.stopKeydownPropagation) {
      e.stopPropagation();
    }

    // ENTER
    if (e.key === 'Enter') {
      handleEnter(instance, e, innerParams);
    }

    // TAB
    else if (e.key === 'Tab') {
      handleTab(e, innerParams);
    }

    // ARROWS - switch focus between buttons
    else if ([...arrowKeysNextButton, ...arrowKeysPreviousButton].includes(e.key)) {
      handleArrows(e.key);
    }

    // ESC
    else if (e.key === 'Escape') {
      handleEsc(e, innerParams, dismissWith);
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {KeyboardEvent} e
   * @param {SweetAlertOptions} innerParams
   */
  const handleEnter = (instance, e, innerParams) => {
    // https://github.com/sweetalert2/sweetalert2/issues/2386
    if (!callIfFunction(innerParams.allowEnterKey)) {
      return;
    }
    if (e.target && instance.getInput() && e.target instanceof HTMLElement && e.target.outerHTML === instance.getInput().outerHTML) {
      if (['textarea', 'file'].includes(innerParams.input)) {
        return; // do not submit
      }

      clickConfirm();
      e.preventDefault();
    }
  };

  /**
   * @param {KeyboardEvent} e
   * @param {SweetAlertOptions} innerParams
   */
  const handleTab = (e, innerParams) => {
    const targetElement = e.target;
    const focusableElements = getFocusableElements();
    let btnIndex = -1;
    for (let i = 0; i < focusableElements.length; i++) {
      if (targetElement === focusableElements[i]) {
        btnIndex = i;
        break;
      }
    }

    // Cycle to the next button
    if (!e.shiftKey) {
      setFocus(innerParams, btnIndex, 1);
    }

    // Cycle to the prev button
    else {
      setFocus(innerParams, btnIndex, -1);
    }
    e.stopPropagation();
    e.preventDefault();
  };

  /**
   * @param {string} key
   */
  const handleArrows = key => {
    const confirmButton = getConfirmButton();
    const denyButton = getDenyButton();
    const cancelButton = getCancelButton();
    if (document.activeElement instanceof HTMLElement && ![confirmButton, denyButton, cancelButton].includes(document.activeElement)) {
      return;
    }
    const sibling = arrowKeysNextButton.includes(key) ? 'nextElementSibling' : 'previousElementSibling';
    let buttonToFocus = document.activeElement;
    for (let i = 0; i < getActions().children.length; i++) {
      buttonToFocus = buttonToFocus[sibling];
      if (!buttonToFocus) {
        return;
      }
      if (buttonToFocus instanceof HTMLButtonElement && isVisible$1(buttonToFocus)) {
        break;
      }
    }
    if (buttonToFocus instanceof HTMLButtonElement) {
      buttonToFocus.focus();
    }
  };

  /**
   * @param {KeyboardEvent} e
   * @param {SweetAlertOptions} innerParams
   * @param {function} dismissWith
   */
  const handleEsc = (e, innerParams, dismissWith) => {
    if (callIfFunction(innerParams.allowEscapeKey)) {
      e.preventDefault();
      dismissWith(DismissReason.esc);
    }
  };

  /**
   * This module contains `WeakMap`s for each effectively-"private  property" that a `Swal` has.
   * For example, to set the private property "foo" of `this` to "bar", you can `privateProps.foo.set(this, 'bar')`
   * This is the approach that Babel will probably take to implement private methods/fields
   *   https://github.com/tc39/proposal-private-methods
   *   https://github.com/babel/babel/pull/7555
   * Once we have the changes from that PR in Babel, and our core class fits reasonable in *one module*
   *   then we can use that language feature.
   */

  var privateMethods = {
    swalPromiseResolve: new WeakMap(),
    swalPromiseReject: new WeakMap()
  };

  // From https://developer.paciellogroup.com/blog/2018/06/the-current-state-of-modal-dialog-accessibility/
  // Adding aria-hidden="true" to elements outside of the active modal dialog ensures that
  // elements not within the active modal dialog will not be surfaced if a user opens a screen
  // reader’s list of elements (headings, form controls, landmarks, etc.) in the document.

  const setAriaHidden = () => {
    const bodyChildren = Array.from(document.body.children);
    bodyChildren.forEach(el => {
      if (el === getContainer() || el.contains(getContainer())) {
        return;
      }
      if (el.hasAttribute('aria-hidden')) {
        el.setAttribute('data-previous-aria-hidden', el.getAttribute('aria-hidden'));
      }
      el.setAttribute('aria-hidden', 'true');
    });
  };
  const unsetAriaHidden = () => {
    const bodyChildren = Array.from(document.body.children);
    bodyChildren.forEach(el => {
      if (el.hasAttribute('data-previous-aria-hidden')) {
        el.setAttribute('aria-hidden', el.getAttribute('data-previous-aria-hidden'));
        el.removeAttribute('data-previous-aria-hidden');
      } else {
        el.removeAttribute('aria-hidden');
      }
    });
  };

  /* istanbul ignore file */

  // Fix iOS scrolling http://stackoverflow.com/q/39626302

  const iOSfix = () => {
    const iOS =
    // @ts-ignore
    /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream || navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1;
    if (iOS && !hasClass(document.body, swalClasses.iosfix)) {
      const offset = document.body.scrollTop;
      document.body.style.top = `${offset * -1}px`;
      addClass(document.body, swalClasses.iosfix);
      lockBodyScroll();
      addBottomPaddingForTallPopups();
    }
  };

  /**
   * https://github.com/sweetalert2/sweetalert2/issues/1948
   */
  const addBottomPaddingForTallPopups = () => {
    const ua = navigator.userAgent;
    const iOS = !!ua.match(/iPad/i) || !!ua.match(/iPhone/i);
    const webkit = !!ua.match(/WebKit/i);
    const iOSSafari = iOS && webkit && !ua.match(/CriOS/i);
    if (iOSSafari) {
      const bottomPanelHeight = 44;
      if (getPopup().scrollHeight > window.innerHeight - bottomPanelHeight) {
        getContainer().style.paddingBottom = `${bottomPanelHeight}px`;
      }
    }
  };

  /**
   * https://github.com/sweetalert2/sweetalert2/issues/1246
   */
  const lockBodyScroll = () => {
    const container = getContainer();
    let preventTouchMove;
    /**
     * @param {TouchEvent} e
     */
    container.ontouchstart = e => {
      preventTouchMove = shouldPreventTouchMove(e);
    };
    /**
     * @param {TouchEvent} e
     */
    container.ontouchmove = e => {
      if (preventTouchMove) {
        e.preventDefault();
        e.stopPropagation();
      }
    };
  };

  /**
   * @param {TouchEvent} event
   * @returns {boolean}
   */
  const shouldPreventTouchMove = event => {
    const target = event.target;
    const container = getContainer();
    if (isStylus(event) || isZoom(event)) {
      return false;
    }
    if (target === container) {
      return true;
    }
    if (!isScrollable(container) && target instanceof HTMLElement && target.tagName !== 'INPUT' &&
    // #1603
    target.tagName !== 'TEXTAREA' &&
    // #2266
    !(isScrollable(getHtmlContainer()) &&
    // #1944
    getHtmlContainer().contains(target))) {
      return true;
    }
    return false;
  };

  /**
   * https://github.com/sweetalert2/sweetalert2/issues/1786
   *
   * @param {*} event
   * @returns {boolean}
   */
  const isStylus = event => {
    return event.touches && event.touches.length && event.touches[0].touchType === 'stylus';
  };

  /**
   * https://github.com/sweetalert2/sweetalert2/issues/1891
   *
   * @param {TouchEvent} event
   * @returns {boolean}
   */
  const isZoom = event => {
    return event.touches && event.touches.length > 1;
  };
  const undoIOSfix = () => {
    if (hasClass(document.body, swalClasses.iosfix)) {
      const offset = parseInt(document.body.style.top, 10);
      removeClass(document.body, swalClasses.iosfix);
      document.body.style.top = '';
      document.body.scrollTop = offset * -1;
    }
  };

  const fixScrollbar = () => {
    // for queues, do not do this more than once
    if (states.previousBodyPadding !== null) {
      return;
    }
    // if the body has overflow
    if (document.body.scrollHeight > window.innerHeight) {
      // add padding so the content doesn't shift after removal of scrollbar
      states.previousBodyPadding = parseInt(window.getComputedStyle(document.body).getPropertyValue('padding-right'));
      document.body.style.paddingRight = `${states.previousBodyPadding + measureScrollbar()}px`;
    }
  };
  const undoScrollbar = () => {
    if (states.previousBodyPadding !== null) {
      document.body.style.paddingRight = `${states.previousBodyPadding}px`;
      states.previousBodyPadding = null;
    }
  };

  /*
   * Instance method to close sweetAlert
   */

  function removePopupAndResetState(instance, container, returnFocus, didClose) {
    if (isToast()) {
      triggerDidCloseAndDispose(instance, didClose);
    } else {
      restoreActiveElement(returnFocus).then(() => triggerDidCloseAndDispose(instance, didClose));
      removeKeydownHandler(globalState);
    }
    const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    // workaround for #2088
    // for some reason removing the container in Safari will scroll the document to bottom
    if (isSafari) {
      container.setAttribute('style', 'display:none !important');
      container.removeAttribute('class');
      container.innerHTML = '';
    } else {
      container.remove();
    }
    if (isModal()) {
      undoScrollbar();
      undoIOSfix();
      unsetAriaHidden();
    }
    removeBodyClasses();
  }
  function removeBodyClasses() {
    removeClass([document.documentElement, document.body], [swalClasses.shown, swalClasses['height-auto'], swalClasses['no-backdrop'], swalClasses['toast-shown']]);
  }
  function close(resolveValue) {
    resolveValue = prepareResolveValue(resolveValue);
    const swalPromiseResolve = privateMethods.swalPromiseResolve.get(this);
    const didClose = triggerClosePopup(this);
    if (this.isAwaitingPromise()) {
      // A swal awaiting for a promise (after a click on Confirm or Deny) cannot be dismissed anymore #2335
      if (!resolveValue.isDismissed) {
        handleAwaitingPromise(this);
        swalPromiseResolve(resolveValue);
      }
    } else if (didClose) {
      // Resolve Swal promise
      swalPromiseResolve(resolveValue);
    }
  }
  function isAwaitingPromise() {
    return !!privateProps.awaitingPromise.get(this);
  }
  const triggerClosePopup = instance => {
    const popup = getPopup();
    if (!popup) {
      return false;
    }
    const innerParams = privateProps.innerParams.get(instance);
    if (!innerParams || hasClass(popup, innerParams.hideClass.popup)) {
      return false;
    }
    removeClass(popup, innerParams.showClass.popup);
    addClass(popup, innerParams.hideClass.popup);
    const backdrop = getContainer();
    removeClass(backdrop, innerParams.showClass.backdrop);
    addClass(backdrop, innerParams.hideClass.backdrop);
    handlePopupAnimation(instance, popup, innerParams);
    return true;
  };
  function rejectPromise(error) {
    const rejectPromise = privateMethods.swalPromiseReject.get(this);
    handleAwaitingPromise(this);
    if (rejectPromise) {
      // Reject Swal promise
      rejectPromise(error);
    }
  }
  const handleAwaitingPromise = instance => {
    if (instance.isAwaitingPromise()) {
      privateProps.awaitingPromise.delete(instance);
      // The instance might have been previously partly destroyed, we must resume the destroy process in this case #2335
      if (!privateProps.innerParams.get(instance)) {
        instance._destroy();
      }
    }
  };
  const prepareResolveValue = resolveValue => {
    // When user calls Swal.close()
    if (typeof resolveValue === 'undefined') {
      return {
        isConfirmed: false,
        isDenied: false,
        isDismissed: true
      };
    }
    return Object.assign({
      isConfirmed: false,
      isDenied: false,
      isDismissed: false
    }, resolveValue);
  };
  const handlePopupAnimation = (instance, popup, innerParams) => {
    const container = getContainer();
    // If animation is supported, animate
    const animationIsSupported = animationEndEvent && hasCssAnimation(popup);
    if (typeof innerParams.willClose === 'function') {
      innerParams.willClose(popup);
    }
    if (animationIsSupported) {
      animatePopup(instance, popup, container, innerParams.returnFocus, innerParams.didClose);
    } else {
      // Otherwise, remove immediately
      removePopupAndResetState(instance, container, innerParams.returnFocus, innerParams.didClose);
    }
  };
  const animatePopup = (instance, popup, container, returnFocus, didClose) => {
    globalState.swalCloseEventFinishedCallback = removePopupAndResetState.bind(null, instance, container, returnFocus, didClose);
    popup.addEventListener(animationEndEvent, function (e) {
      if (e.target === popup) {
        globalState.swalCloseEventFinishedCallback();
        delete globalState.swalCloseEventFinishedCallback;
      }
    });
  };
  const triggerDidCloseAndDispose = (instance, didClose) => {
    setTimeout(() => {
      if (typeof didClose === 'function') {
        didClose.bind(instance.params)();
      }
      instance._destroy();
    });
  };

  /**
   * @param {SweetAlert2} instance
   * @param {string[]} buttons
   * @param {boolean} disabled
   */
  function setButtonsDisabled(instance, buttons, disabled) {
    const domCache = privateProps.domCache.get(instance);
    buttons.forEach(button => {
      domCache[button].disabled = disabled;
    });
  }

  /**
   * @param {HTMLInputElement} input
   * @param {boolean} disabled
   */
  function setInputDisabled(input, disabled) {
    if (!input) {
      return;
    }
    if (input.type === 'radio') {
      const radiosContainer = input.parentNode.parentNode;
      const radios = radiosContainer.querySelectorAll('input');
      for (let i = 0; i < radios.length; i++) {
        radios[i].disabled = disabled;
      }
    } else {
      input.disabled = disabled;
    }
  }
  function enableButtons() {
    setButtonsDisabled(this, ['confirmButton', 'denyButton', 'cancelButton'], false);
  }
  function disableButtons() {
    setButtonsDisabled(this, ['confirmButton', 'denyButton', 'cancelButton'], true);
  }
  function enableInput() {
    setInputDisabled(this.getInput(), false);
  }
  function disableInput() {
    setInputDisabled(this.getInput(), true);
  }

  // Show block with validation message
  function showValidationMessage(error) {
    const domCache = privateProps.domCache.get(this);
    const params = privateProps.innerParams.get(this);
    setInnerHtml(domCache.validationMessage, error);
    domCache.validationMessage.className = swalClasses['validation-message'];
    if (params.customClass && params.customClass.validationMessage) {
      addClass(domCache.validationMessage, params.customClass.validationMessage);
    }
    show(domCache.validationMessage);
    const input = this.getInput();
    if (input) {
      input.setAttribute('aria-invalid', true);
      input.setAttribute('aria-describedby', swalClasses['validation-message']);
      focusInput(input);
      addClass(input, swalClasses.inputerror);
    }
  }

  // Hide block with validation message
  function resetValidationMessage() {
    const domCache = privateProps.domCache.get(this);
    if (domCache.validationMessage) {
      hide(domCache.validationMessage);
    }
    const input = this.getInput();
    if (input) {
      input.removeAttribute('aria-invalid');
      input.removeAttribute('aria-describedby');
      removeClass(input, swalClasses.inputerror);
    }
  }

  function getProgressSteps() {
    const domCache = privateProps.domCache.get(this);
    return domCache.progressSteps;
  }

  const defaultParams = {
    title: '',
    titleText: '',
    text: '',
    html: '',
    footer: '',
    icon: undefined,
    iconColor: undefined,
    iconHtml: undefined,
    template: undefined,
    toast: false,
    showClass: {
      popup: 'swal2-show',
      backdrop: 'swal2-backdrop-show',
      icon: 'swal2-icon-show'
    },
    hideClass: {
      popup: 'swal2-hide',
      backdrop: 'swal2-backdrop-hide',
      icon: 'swal2-icon-hide'
    },
    customClass: {},
    target: 'body',
    color: undefined,
    backdrop: true,
    heightAuto: true,
    allowOutsideClick: true,
    allowEscapeKey: true,
    allowEnterKey: true,
    stopKeydownPropagation: true,
    keydownListenerCapture: false,
    showConfirmButton: true,
    showDenyButton: false,
    showCancelButton: false,
    preConfirm: undefined,
    preDeny: undefined,
    confirmButtonText: 'OK',
    confirmButtonAriaLabel: '',
    confirmButtonColor: undefined,
    denyButtonText: 'No',
    denyButtonAriaLabel: '',
    denyButtonColor: undefined,
    cancelButtonText: 'Cancel',
    cancelButtonAriaLabel: '',
    cancelButtonColor: undefined,
    buttonsStyling: true,
    reverseButtons: false,
    focusConfirm: true,
    focusDeny: false,
    focusCancel: false,
    returnFocus: true,
    showCloseButton: false,
    closeButtonHtml: '&times;',
    closeButtonAriaLabel: 'Close this dialog',
    loaderHtml: '',
    showLoaderOnConfirm: false,
    showLoaderOnDeny: false,
    imageUrl: undefined,
    imageWidth: undefined,
    imageHeight: undefined,
    imageAlt: '',
    timer: undefined,
    timerProgressBar: false,
    width: undefined,
    padding: undefined,
    background: undefined,
    input: undefined,
    inputPlaceholder: '',
    inputLabel: '',
    inputValue: '',
    inputOptions: {},
    inputAutoTrim: true,
    inputAttributes: {},
    inputValidator: undefined,
    returnInputValueOnDeny: false,
    validationMessage: undefined,
    grow: false,
    position: 'center',
    progressSteps: [],
    currentProgressStep: undefined,
    progressStepsDistance: undefined,
    willOpen: undefined,
    didOpen: undefined,
    didRender: undefined,
    willClose: undefined,
    didClose: undefined,
    didDestroy: undefined,
    scrollbarPadding: true
  };
  const updatableParams = ['allowEscapeKey', 'allowOutsideClick', 'background', 'buttonsStyling', 'cancelButtonAriaLabel', 'cancelButtonColor', 'cancelButtonText', 'closeButtonAriaLabel', 'closeButtonHtml', 'color', 'confirmButtonAriaLabel', 'confirmButtonColor', 'confirmButtonText', 'currentProgressStep', 'customClass', 'denyButtonAriaLabel', 'denyButtonColor', 'denyButtonText', 'didClose', 'didDestroy', 'footer', 'hideClass', 'html', 'icon', 'iconColor', 'iconHtml', 'imageAlt', 'imageHeight', 'imageUrl', 'imageWidth', 'preConfirm', 'preDeny', 'progressSteps', 'returnFocus', 'reverseButtons', 'showCancelButton', 'showCloseButton', 'showConfirmButton', 'showDenyButton', 'text', 'title', 'titleText', 'willClose'];
  const deprecatedParams = {};
  const toastIncompatibleParams = ['allowOutsideClick', 'allowEnterKey', 'backdrop', 'focusConfirm', 'focusDeny', 'focusCancel', 'returnFocus', 'heightAuto', 'keydownListenerCapture'];

  /**
   * Is valid parameter
   *
   * @param {string} paramName
   * @returns {boolean}
   */
  const isValidParameter = paramName => {
    return Object.prototype.hasOwnProperty.call(defaultParams, paramName);
  };

  /**
   * Is valid parameter for Swal.update() method
   *
   * @param {string} paramName
   * @returns {boolean}
   */
  const isUpdatableParameter = paramName => {
    return updatableParams.indexOf(paramName) !== -1;
  };

  /**
   * Is deprecated parameter
   *
   * @param {string} paramName
   * @returns {string | undefined}
   */
  const isDeprecatedParameter = paramName => {
    return deprecatedParams[paramName];
  };

  /**
   * @param {string} param
   */
  const checkIfParamIsValid = param => {
    if (!isValidParameter(param)) {
      warn(`Unknown parameter "${param}"`);
    }
  };

  /**
   * @param {string} param
   */
  const checkIfToastParamIsValid = param => {
    if (toastIncompatibleParams.includes(param)) {
      warn(`The parameter "${param}" is incompatible with toasts`);
    }
  };

  /**
   * @param {string} param
   */
  const checkIfParamIsDeprecated = param => {
    if (isDeprecatedParameter(param)) {
      warnAboutDeprecation(param, isDeprecatedParameter(param));
    }
  };

  /**
   * Show relevant warnings for given params
   *
   * @param {SweetAlertOptions} params
   */
  const showWarningsForParams = params => {
    if (params.backdrop === false && params.allowOutsideClick) {
      warn('"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`');
    }
    for (const param in params) {
      checkIfParamIsValid(param);
      if (params.toast) {
        checkIfToastParamIsValid(param);
      }
      checkIfParamIsDeprecated(param);
    }
  };

  /**
   * Updates popup parameters.
   */
  function update(params) {
    const popup = getPopup();
    const innerParams = privateProps.innerParams.get(this);
    if (!popup || hasClass(popup, innerParams.hideClass.popup)) {
      return warn(`You're trying to update the closed or closing popup, that won't work. Use the update() method in preConfirm parameter or show a new popup.`);
    }
    const validUpdatableParams = filterValidParams(params);
    const updatedParams = Object.assign({}, innerParams, validUpdatableParams);
    render(this, updatedParams);
    privateProps.innerParams.set(this, updatedParams);
    Object.defineProperties(this, {
      params: {
        value: Object.assign({}, this.params, params),
        writable: false,
        enumerable: true
      }
    });
  }
  const filterValidParams = params => {
    const validUpdatableParams = {};
    Object.keys(params).forEach(param => {
      if (isUpdatableParameter(param)) {
        validUpdatableParams[param] = params[param];
      } else {
        warn(`Invalid parameter to update: ${param}`);
      }
    });
    return validUpdatableParams;
  };

  function _destroy() {
    const domCache = privateProps.domCache.get(this);
    const innerParams = privateProps.innerParams.get(this);
    if (!innerParams) {
      disposeWeakMaps(this); // The WeakMaps might have been partly destroyed, we must recall it to dispose any remaining WeakMaps #2335
      return; // This instance has already been destroyed
    }

    // Check if there is another Swal closing
    if (domCache.popup && globalState.swalCloseEventFinishedCallback) {
      globalState.swalCloseEventFinishedCallback();
      delete globalState.swalCloseEventFinishedCallback;
    }
    if (typeof innerParams.didDestroy === 'function') {
      innerParams.didDestroy();
    }
    disposeSwal(this);
  }

  /**
   * @param {SweetAlert2} instance
   */
  const disposeSwal = instance => {
    disposeWeakMaps(instance);
    // Unset this.params so GC will dispose it (#1569)
    // @ts-ignore
    delete instance.params;
    // Unset globalState props so GC will dispose globalState (#1569)
    delete globalState.keydownHandler;
    delete globalState.keydownTarget;
    // Unset currentInstance
    delete globalState.currentInstance;
  };

  /**
   * @param {SweetAlert2} instance
   */
  const disposeWeakMaps = instance => {
    // If the current instance is awaiting a promise result, we keep the privateMethods to call them once the promise result is retrieved #2335
    // @ts-ignore
    if (instance.isAwaitingPromise()) {
      unsetWeakMaps(privateProps, instance);
      privateProps.awaitingPromise.set(instance, true);
    } else {
      unsetWeakMaps(privateMethods, instance);
      unsetWeakMaps(privateProps, instance);
    }
  };

  /**
   * @param {object} obj
   * @param {SweetAlert2} instance
   */
  const unsetWeakMaps = (obj, instance) => {
    for (const i in obj) {
      obj[i].delete(instance);
    }
  };

  var instanceMethods = /*#__PURE__*/Object.freeze({
    __proto__: null,
    hideLoading: hideLoading,
    disableLoading: hideLoading,
    getInput: getInput,
    close: close,
    isAwaitingPromise: isAwaitingPromise,
    rejectPromise: rejectPromise,
    handleAwaitingPromise: handleAwaitingPromise,
    closePopup: close,
    closeModal: close,
    closeToast: close,
    enableButtons: enableButtons,
    disableButtons: disableButtons,
    enableInput: enableInput,
    disableInput: disableInput,
    showValidationMessage: showValidationMessage,
    resetValidationMessage: resetValidationMessage,
    getProgressSteps: getProgressSteps,
    update: update,
    _destroy: _destroy
  });

  /**
   * Shows loader (spinner), this is useful with AJAX requests.
   * By default the loader be shown instead of the "Confirm" button.
   */
  const showLoading = buttonToReplace => {
    let popup = getPopup();
    if (!popup) {
      new Swal(); // eslint-disable-line no-new
    }

    popup = getPopup();
    const loader = getLoader();
    if (isToast()) {
      hide(getIcon());
    } else {
      replaceButton(popup, buttonToReplace);
    }
    show(loader);
    popup.setAttribute('data-loading', 'true');
    popup.setAttribute('aria-busy', 'true');
    popup.focus();
  };
  const replaceButton = (popup, buttonToReplace) => {
    const actions = getActions();
    const loader = getLoader();
    if (!buttonToReplace && isVisible$1(getConfirmButton())) {
      buttonToReplace = getConfirmButton();
    }
    show(actions);
    if (buttonToReplace) {
      hide(buttonToReplace);
      loader.setAttribute('data-button-to-replace', buttonToReplace.className);
    }
    loader.parentNode.insertBefore(loader, buttonToReplace);
    addClass([popup, actions], swalClasses.loading);
  };

  /**
   * @typedef { string | number | boolean } InputValue
   */

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const handleInputOptionsAndValue = (instance, params) => {
    if (params.input === 'select' || params.input === 'radio') {
      handleInputOptions(instance, params);
    } else if (['text', 'email', 'number', 'tel', 'textarea'].includes(params.input) && (hasToPromiseFn(params.inputValue) || isPromise(params.inputValue))) {
      showLoading(getConfirmButton());
      handleInputValue(instance, params);
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} innerParams
   * @returns {string | number | File | FileList | null}
   */
  const getInputValue = (instance, innerParams) => {
    const input = instance.getInput();
    if (!input) {
      return null;
    }
    switch (innerParams.input) {
      case 'checkbox':
        return getCheckboxValue(input);
      case 'radio':
        return getRadioValue(input);
      case 'file':
        return getFileValue(input);
      default:
        return innerParams.inputAutoTrim ? input.value.trim() : input.value;
    }
  };

  /**
   * @param {HTMLInputElement} input
   * @returns {number}
   */
  const getCheckboxValue = input => input.checked ? 1 : 0;

  /**
   * @param {HTMLInputElement} input
   * @returns {string | null}
   */
  const getRadioValue = input => input.checked ? input.value : null;

  /**
   * @param {HTMLInputElement} input
   * @returns {FileList | File | null}
   */
  const getFileValue = input => input.files.length ? input.getAttribute('multiple') !== null ? input.files : input.files[0] : null;

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const handleInputOptions = (instance, params) => {
    const popup = getPopup();
    /**
     * @param {Record<string, any>} inputOptions
     */
    const processInputOptions = inputOptions => {
      populateInputOptions[params.input](popup, formatInputOptions(inputOptions), params);
    };
    if (hasToPromiseFn(params.inputOptions) || isPromise(params.inputOptions)) {
      showLoading(getConfirmButton());
      asPromise(params.inputOptions).then(inputOptions => {
        instance.hideLoading();
        processInputOptions(inputOptions);
      });
    } else if (typeof params.inputOptions === 'object') {
      processInputOptions(params.inputOptions);
    } else {
      error(`Unexpected type of inputOptions! Expected object, Map or Promise, got ${typeof params.inputOptions}`);
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {SweetAlertOptions} params
   */
  const handleInputValue = (instance, params) => {
    const input = instance.getInput();
    hide(input);
    asPromise(params.inputValue).then(inputValue => {
      input.value = params.input === 'number' ? `${parseFloat(inputValue) || 0}` : `${inputValue}`;
      show(input);
      input.focus();
      instance.hideLoading();
    }).catch(err => {
      error(`Error in inputValue promise: ${err}`);
      input.value = '';
      show(input);
      input.focus();
      instance.hideLoading();
    });
  };
  const populateInputOptions = {
    /**
     * @param {HTMLElement} popup
     * @param {Record<string, any>} inputOptions
     * @param {SweetAlertOptions} params
     */
    select: (popup, inputOptions, params) => {
      const select = getDirectChildByClass(popup, swalClasses.select);
      /**
       * @param {HTMLElement} parent
       * @param {string} optionLabel
       * @param {string} optionValue
       */
      const renderOption = (parent, optionLabel, optionValue) => {
        const option = document.createElement('option');
        option.value = optionValue;
        setInnerHtml(option, optionLabel);
        option.selected = isSelected(optionValue, params.inputValue);
        parent.appendChild(option);
      };
      inputOptions.forEach(inputOption => {
        const optionValue = inputOption[0];
        const optionLabel = inputOption[1];
        // <optgroup> spec:
        // https://www.w3.org/TR/html401/interact/forms.html#h-17.6
        // "...all OPTGROUP elements must be specified directly within a SELECT element (i.e., groups may not be nested)..."
        // check whether this is a <optgroup>
        if (Array.isArray(optionLabel)) {
          // if it is an array, then it is an <optgroup>
          const optgroup = document.createElement('optgroup');
          optgroup.label = optionValue;
          optgroup.disabled = false; // not configurable for now
          select.appendChild(optgroup);
          optionLabel.forEach(o => renderOption(optgroup, o[1], o[0]));
        } else {
          // case of <option>
          renderOption(select, optionLabel, optionValue);
        }
      });
      select.focus();
    },
    /**
     * @param {HTMLElement} popup
     * @param {Record<string, any>} inputOptions
     * @param {SweetAlertOptions} params
     */
    radio: (popup, inputOptions, params) => {
      const radio = getDirectChildByClass(popup, swalClasses.radio);
      inputOptions.forEach(inputOption => {
        const radioValue = inputOption[0];
        const radioLabel = inputOption[1];
        const radioInput = document.createElement('input');
        const radioLabelElement = document.createElement('label');
        radioInput.type = 'radio';
        radioInput.name = swalClasses.radio;
        radioInput.value = radioValue;
        if (isSelected(radioValue, params.inputValue)) {
          radioInput.checked = true;
        }
        const label = document.createElement('span');
        setInnerHtml(label, radioLabel);
        label.className = swalClasses.label;
        radioLabelElement.appendChild(radioInput);
        radioLabelElement.appendChild(label);
        radio.appendChild(radioLabelElement);
      });
      const radios = radio.querySelectorAll('input');
      if (radios.length) {
        radios[0].focus();
      }
    }
  };

  /**
   * Converts `inputOptions` into an array of `[value, label]`s
   *
   * @param {Record<string, any>} inputOptions
   * @returns {Array<Array<string>>}
   */
  const formatInputOptions = inputOptions => {
    const result = [];
    if (typeof Map !== 'undefined' && inputOptions instanceof Map) {
      inputOptions.forEach((value, key) => {
        let valueFormatted = value;
        if (typeof valueFormatted === 'object') {
          // case of <optgroup>
          valueFormatted = formatInputOptions(valueFormatted);
        }
        result.push([key, valueFormatted]);
      });
    } else {
      Object.keys(inputOptions).forEach(key => {
        let valueFormatted = inputOptions[key];
        if (typeof valueFormatted === 'object') {
          // case of <optgroup>
          valueFormatted = formatInputOptions(valueFormatted);
        }
        result.push([key, valueFormatted]);
      });
    }
    return result;
  };

  /**
   * @param {string} optionValue
   * @param {InputValue | Promise<InputValue> | { toPromise: () => InputValue }} inputValue
   * @returns {boolean}
   */
  const isSelected = (optionValue, inputValue) => {
    return inputValue && inputValue.toString() === optionValue.toString();
  };

  /**
   * @param {SweetAlert2} instance
   */
  const handleConfirmButtonClick = instance => {
    const innerParams = privateProps.innerParams.get(instance);
    instance.disableButtons();
    if (innerParams.input) {
      handleConfirmOrDenyWithInput(instance, 'confirm');
    } else {
      confirm(instance, true);
    }
  };

  /**
   * @param {SweetAlert2} instance
   */
  const handleDenyButtonClick = instance => {
    const innerParams = privateProps.innerParams.get(instance);
    instance.disableButtons();
    if (innerParams.returnInputValueOnDeny) {
      handleConfirmOrDenyWithInput(instance, 'deny');
    } else {
      deny(instance, false);
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {Function} dismissWith
   */
  const handleCancelButtonClick = (instance, dismissWith) => {
    instance.disableButtons();
    dismissWith(DismissReason.cancel);
  };

  /**
   * @param {SweetAlert2} instance
   * @param {'confirm' | 'deny'} type
   */
  const handleConfirmOrDenyWithInput = (instance, type) => {
    const innerParams = privateProps.innerParams.get(instance);
    if (!innerParams.input) {
      error(`The "input" parameter is needed to be set when using returnInputValueOn${capitalizeFirstLetter(type)}`);
      return;
    }
    const inputValue = getInputValue(instance, innerParams);
    if (innerParams.inputValidator) {
      handleInputValidator(instance, inputValue, type);
    } else if (!instance.getInput().checkValidity()) {
      instance.enableButtons();
      instance.showValidationMessage(innerParams.validationMessage);
    } else if (type === 'deny') {
      deny(instance, inputValue);
    } else {
      confirm(instance, inputValue);
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {string | number | File | FileList | null} inputValue
   * @param {'confirm' | 'deny'} type
   */
  const handleInputValidator = (instance, inputValue, type) => {
    const innerParams = privateProps.innerParams.get(instance);
    instance.disableInput();
    const validationPromise = Promise.resolve().then(() => asPromise(innerParams.inputValidator(inputValue, innerParams.validationMessage)));
    validationPromise.then(validationMessage => {
      instance.enableButtons();
      instance.enableInput();
      if (validationMessage) {
        instance.showValidationMessage(validationMessage);
      } else if (type === 'deny') {
        deny(instance, inputValue);
      } else {
        confirm(instance, inputValue);
      }
    });
  };

  /**
   * @param {SweetAlert2} instance
   * @param {any} value
   */
  const deny = (instance, value) => {
    const innerParams = privateProps.innerParams.get(instance || undefined);
    if (innerParams.showLoaderOnDeny) {
      showLoading(getDenyButton());
    }
    if (innerParams.preDeny) {
      privateProps.awaitingPromise.set(instance || undefined, true); // Flagging the instance as awaiting a promise so it's own promise's reject/resolve methods doesn't get destroyed until the result from this preDeny's promise is received
      const preDenyPromise = Promise.resolve().then(() => asPromise(innerParams.preDeny(value, innerParams.validationMessage)));
      preDenyPromise.then(preDenyValue => {
        if (preDenyValue === false) {
          instance.hideLoading();
          handleAwaitingPromise(instance);
        } else {
          instance.close({
            isDenied: true,
            value: typeof preDenyValue === 'undefined' ? value : preDenyValue
          });
        }
      }).catch(error => rejectWith(instance || undefined, error));
    } else {
      instance.close({
        isDenied: true,
        value
      });
    }
  };

  /**
   * @param {SweetAlert2} instance
   * @param {any} value
   */
  const succeedWith = (instance, value) => {
    instance.close({
      isConfirmed: true,
      value
    });
  };

  /**
   *
   * @param {SweetAlert2} instance
   * @param {string} error
   */
  const rejectWith = (instance, error) => {
    // @ts-ignore
    instance.rejectPromise(error);
  };

  /**
   *
   * @param {SweetAlert2} instance
   * @param {any} value
   */
  const confirm = (instance, value) => {
    const innerParams = privateProps.innerParams.get(instance || undefined);
    if (innerParams.showLoaderOnConfirm) {
      showLoading();
    }
    if (innerParams.preConfirm) {
      instance.resetValidationMessage();
      privateProps.awaitingPromise.set(instance || undefined, true); // Flagging the instance as awaiting a promise so it's own promise's reject/resolve methods doesn't get destroyed until the result from this preConfirm's promise is received
      const preConfirmPromise = Promise.resolve().then(() => asPromise(innerParams.preConfirm(value, innerParams.validationMessage)));
      preConfirmPromise.then(preConfirmValue => {
        if (isVisible$1(getValidationMessage()) || preConfirmValue === false) {
          instance.hideLoading();
          handleAwaitingPromise(instance);
        } else {
          succeedWith(instance, typeof preConfirmValue === 'undefined' ? value : preConfirmValue);
        }
      }).catch(error => rejectWith(instance || undefined, error));
    } else {
      succeedWith(instance, value);
    }
  };

  const handlePopupClick = (instance, domCache, dismissWith) => {
    const innerParams = privateProps.innerParams.get(instance);
    if (innerParams.toast) {
      handleToastClick(instance, domCache, dismissWith);
    } else {
      // Ignore click events that had mousedown on the popup but mouseup on the container
      // This can happen when the user drags a slider
      handleModalMousedown(domCache);

      // Ignore click events that had mousedown on the container but mouseup on the popup
      handleContainerMousedown(domCache);
      handleModalClick(instance, domCache, dismissWith);
    }
  };
  const handleToastClick = (instance, domCache, dismissWith) => {
    // Closing toast by internal click
    domCache.popup.onclick = () => {
      const innerParams = privateProps.innerParams.get(instance);
      if (innerParams && (isAnyButtonShown(innerParams) || innerParams.timer || innerParams.input)) {
        return;
      }
      dismissWith(DismissReason.close);
    };
  };

  /**
   * @param {*} innerParams
   * @returns {boolean}
   */
  const isAnyButtonShown = innerParams => {
    return innerParams.showConfirmButton || innerParams.showDenyButton || innerParams.showCancelButton || innerParams.showCloseButton;
  };
  let ignoreOutsideClick = false;
  const handleModalMousedown = domCache => {
    domCache.popup.onmousedown = () => {
      domCache.container.onmouseup = function (e) {
        domCache.container.onmouseup = undefined;
        // We only check if the mouseup target is the container because usually it doesn't
        // have any other direct children aside of the popup
        if (e.target === domCache.container) {
          ignoreOutsideClick = true;
        }
      };
    };
  };
  const handleContainerMousedown = domCache => {
    domCache.container.onmousedown = () => {
      domCache.popup.onmouseup = function (e) {
        domCache.popup.onmouseup = undefined;
        // We also need to check if the mouseup target is a child of the popup
        if (e.target === domCache.popup || domCache.popup.contains(e.target)) {
          ignoreOutsideClick = true;
        }
      };
    };
  };
  const handleModalClick = (instance, domCache, dismissWith) => {
    domCache.container.onclick = e => {
      const innerParams = privateProps.innerParams.get(instance);
      if (ignoreOutsideClick) {
        ignoreOutsideClick = false;
        return;
      }
      if (e.target === domCache.container && callIfFunction(innerParams.allowOutsideClick)) {
        dismissWith(DismissReason.backdrop);
      }
    };
  };

  const isJqueryElement = elem => typeof elem === 'object' && elem.jquery;
  const isElement = elem => elem instanceof Element || isJqueryElement(elem);
  const argsToParams = args => {
    const params = {};
    if (typeof args[0] === 'object' && !isElement(args[0])) {
      Object.assign(params, args[0]);
    } else {
      ['title', 'html', 'icon'].forEach((name, index) => {
        const arg = args[index];
        if (typeof arg === 'string' || isElement(arg)) {
          params[name] = arg;
        } else if (arg !== undefined) {
          error(`Unexpected type of ${name}! Expected "string" or "Element", got ${typeof arg}`);
        }
      });
    }
    return params;
  };

  function fire() {
    const Swal = this; // eslint-disable-line @typescript-eslint/no-this-alias
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }
    return new Swal(...args);
  }

  /**
   * Returns an extended version of `Swal` containing `params` as defaults.
   * Useful for reusing Swal configuration.
   *
   * For example:
   *
   * Before:
   * const textPromptOptions = { input: 'text', showCancelButton: true }
   * const {value: firstName} = await Swal.fire({ ...textPromptOptions, title: 'What is your first name?' })
   * const {value: lastName} = await Swal.fire({ ...textPromptOptions, title: 'What is your last name?' })
   *
   * After:
   * const TextPrompt = Swal.mixin({ input: 'text', showCancelButton: true })
   * const {value: firstName} = await TextPrompt('What is your first name?')
   * const {value: lastName} = await TextPrompt('What is your last name?')
   *
   * @param mixinParams
   */
  function mixin(mixinParams) {
    class MixinSwal extends this {
      _main(params, priorityMixinParams) {
        return super._main(params, Object.assign({}, mixinParams, priorityMixinParams));
      }
    }
    return MixinSwal;
  }

  /**
   * If `timer` parameter is set, returns number of milliseconds of timer remained.
   * Otherwise, returns undefined.
   *
   * @returns {number | undefined}
   */
  const getTimerLeft = () => {
    return globalState.timeout && globalState.timeout.getTimerLeft();
  };

  /**
   * Stop timer. Returns number of milliseconds of timer remained.
   * If `timer` parameter isn't set, returns undefined.
   *
   * @returns {number | undefined}
   */
  const stopTimer = () => {
    if (globalState.timeout) {
      stopTimerProgressBar();
      return globalState.timeout.stop();
    }
  };

  /**
   * Resume timer. Returns number of milliseconds of timer remained.
   * If `timer` parameter isn't set, returns undefined.
   *
   * @returns {number | undefined}
   */
  const resumeTimer = () => {
    if (globalState.timeout) {
      const remaining = globalState.timeout.start();
      animateTimerProgressBar(remaining);
      return remaining;
    }
  };

  /**
   * Resume timer. Returns number of milliseconds of timer remained.
   * If `timer` parameter isn't set, returns undefined.
   *
   * @returns {number | undefined}
   */
  const toggleTimer = () => {
    const timer = globalState.timeout;
    return timer && (timer.running ? stopTimer() : resumeTimer());
  };

  /**
   * Increase timer. Returns number of milliseconds of an updated timer.
   * If `timer` parameter isn't set, returns undefined.
   *
   * @param {number} n
   * @returns {number | undefined}
   */
  const increaseTimer = n => {
    if (globalState.timeout) {
      const remaining = globalState.timeout.increase(n);
      animateTimerProgressBar(remaining, true);
      return remaining;
    }
  };

  /**
   * Check if timer is running. Returns true if timer is running
   * or false if timer is paused or stopped.
   * If `timer` parameter isn't set, returns undefined
   *
   * @returns {boolean}
   */
  const isTimerRunning = () => {
    return globalState.timeout && globalState.timeout.isRunning();
  };

  let bodyClickListenerAdded = false;
  const clickHandlers = {};
  function bindClickHandler() {
    let attr = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'data-swal-template';
    clickHandlers[attr] = this;
    if (!bodyClickListenerAdded) {
      document.body.addEventListener('click', bodyClickListener);
      bodyClickListenerAdded = true;
    }
  }
  const bodyClickListener = event => {
    for (let el = event.target; el && el !== document; el = el.parentNode) {
      for (const attr in clickHandlers) {
        const template = el.getAttribute(attr);
        if (template) {
          clickHandlers[attr].fire({
            template
          });
          return;
        }
      }
    }
  };

  var staticMethods = /*#__PURE__*/Object.freeze({
    __proto__: null,
    isValidParameter: isValidParameter,
    isUpdatableParameter: isUpdatableParameter,
    isDeprecatedParameter: isDeprecatedParameter,
    argsToParams: argsToParams,
    getContainer: getContainer,
    getPopup: getPopup,
    getTitle: getTitle,
    getHtmlContainer: getHtmlContainer,
    getImage: getImage,
    getIcon: getIcon,
    getIconContent: getIconContent,
    getInputLabel: getInputLabel,
    getCloseButton: getCloseButton,
    getActions: getActions,
    getConfirmButton: getConfirmButton,
    getDenyButton: getDenyButton,
    getCancelButton: getCancelButton,
    getLoader: getLoader,
    getFooter: getFooter,
    getTimerProgressBar: getTimerProgressBar,
    getFocusableElements: getFocusableElements,
    getValidationMessage: getValidationMessage,
    isLoading: isLoading,
    isVisible: isVisible,
    clickConfirm: clickConfirm,
    clickDeny: clickDeny,
    clickCancel: clickCancel,
    fire: fire,
    mixin: mixin,
    showLoading: showLoading,
    enableLoading: showLoading,
    getTimerLeft: getTimerLeft,
    stopTimer: stopTimer,
    resumeTimer: resumeTimer,
    toggleTimer: toggleTimer,
    increaseTimer: increaseTimer,
    isTimerRunning: isTimerRunning,
    bindClickHandler: bindClickHandler
  });

  class Timer {
    /**
     * @param {Function} callback
     * @param {number} delay
     */
    constructor(callback, delay) {
      this.callback = callback;
      this.remaining = delay;
      this.running = false;
      this.start();
    }
    start() {
      if (!this.running) {
        this.running = true;
        this.started = new Date();
        this.id = setTimeout(this.callback, this.remaining);
      }
      return this.remaining;
    }
    stop() {
      if (this.running) {
        this.running = false;
        clearTimeout(this.id);
        this.remaining -= new Date().getTime() - this.started.getTime();
      }
      return this.remaining;
    }
    increase(n) {
      const running = this.running;
      if (running) {
        this.stop();
      }
      this.remaining += n;
      if (running) {
        this.start();
      }
      return this.remaining;
    }
    getTimerLeft() {
      if (this.running) {
        this.stop();
        this.start();
      }
      return this.remaining;
    }
    isRunning() {
      return this.running;
    }
  }

  const swalStringParams = ['swal-title', 'swal-html', 'swal-footer'];

  /**
   * @param {SweetAlertOptions} params
   * @returns {SweetAlertOptions}
   */
  const getTemplateParams = params => {
    /** @type {HTMLTemplateElement} */
    const template = typeof params.template === 'string' ? document.querySelector(params.template) : params.template;
    if (!template) {
      return {};
    }
    /** @type {DocumentFragment} */
    const templateContent = template.content;
    showWarningsForElements(templateContent);
    const result = Object.assign(getSwalParams(templateContent), getSwalFunctionParams(templateContent), getSwalButtons(templateContent), getSwalImage(templateContent), getSwalIcon(templateContent), getSwalInput(templateContent), getSwalStringParams(templateContent, swalStringParams));
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   * @returns {SweetAlertOptions}
   */
  const getSwalParams = templateContent => {
    const result = {};
    /** @type {HTMLElement[]} */
    const swalParams = Array.from(templateContent.querySelectorAll('swal-param'));
    swalParams.forEach(param => {
      showWarningsForAttributes(param, ['name', 'value']);
      const paramName = param.getAttribute('name');
      const value = param.getAttribute('value');
      if (typeof defaultParams[paramName] === 'boolean') {
        result[paramName] = value !== 'false';
      } else if (typeof defaultParams[paramName] === 'object') {
        result[paramName] = JSON.parse(value);
      } else {
        result[paramName] = value;
      }
    });
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   * @returns {SweetAlertOptions}
   */
  const getSwalFunctionParams = templateContent => {
    const result = {};
    /** @type {HTMLElement[]} */
    const swalFunctions = Array.from(templateContent.querySelectorAll('swal-function-param'));
    swalFunctions.forEach(param => {
      const paramName = param.getAttribute('name');
      const value = param.getAttribute('value');
      result[paramName] = new Function(`return ${value}`)();
    });
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   * @returns {SweetAlertOptions}
   */
  const getSwalButtons = templateContent => {
    const result = {};
    /** @type {HTMLElement[]} */
    const swalButtons = Array.from(templateContent.querySelectorAll('swal-button'));
    swalButtons.forEach(button => {
      showWarningsForAttributes(button, ['type', 'color', 'aria-label']);
      const type = button.getAttribute('type');
      result[`${type}ButtonText`] = button.innerHTML;
      result[`show${capitalizeFirstLetter(type)}Button`] = true;
      if (button.hasAttribute('color')) {
        result[`${type}ButtonColor`] = button.getAttribute('color');
      }
      if (button.hasAttribute('aria-label')) {
        result[`${type}ButtonAriaLabel`] = button.getAttribute('aria-label');
      }
    });
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   * @returns {SweetAlertOptions}
   */
  const getSwalImage = templateContent => {
    const result = {};
    /** @type {HTMLElement} */
    const image = templateContent.querySelector('swal-image');
    if (image) {
      showWarningsForAttributes(image, ['src', 'width', 'height', 'alt']);
      if (image.hasAttribute('src')) {
        result.imageUrl = image.getAttribute('src');
      }
      if (image.hasAttribute('width')) {
        result.imageWidth = image.getAttribute('width');
      }
      if (image.hasAttribute('height')) {
        result.imageHeight = image.getAttribute('height');
      }
      if (image.hasAttribute('alt')) {
        result.imageAlt = image.getAttribute('alt');
      }
    }
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   * @returns {SweetAlertOptions}
   */
  const getSwalIcon = templateContent => {
    const result = {};
    /** @type {HTMLElement} */
    const icon = templateContent.querySelector('swal-icon');
    if (icon) {
      showWarningsForAttributes(icon, ['type', 'color']);
      if (icon.hasAttribute('type')) {
        /** @type {SweetAlertIcon} */
        // @ts-ignore
        result.icon = icon.getAttribute('type');
      }
      if (icon.hasAttribute('color')) {
        result.iconColor = icon.getAttribute('color');
      }
      result.iconHtml = icon.innerHTML;
    }
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   * @returns {SweetAlertOptions}
   */
  const getSwalInput = templateContent => {
    const result = {};
    /** @type {HTMLElement} */
    const input = templateContent.querySelector('swal-input');
    if (input) {
      showWarningsForAttributes(input, ['type', 'label', 'placeholder', 'value']);
      /** @type {SweetAlertInput} */
      // @ts-ignore
      result.input = input.getAttribute('type') || 'text';
      if (input.hasAttribute('label')) {
        result.inputLabel = input.getAttribute('label');
      }
      if (input.hasAttribute('placeholder')) {
        result.inputPlaceholder = input.getAttribute('placeholder');
      }
      if (input.hasAttribute('value')) {
        result.inputValue = input.getAttribute('value');
      }
    }
    /** @type {HTMLElement[]} */
    const inputOptions = Array.from(templateContent.querySelectorAll('swal-input-option'));
    if (inputOptions.length) {
      result.inputOptions = {};
      inputOptions.forEach(option => {
        showWarningsForAttributes(option, ['value']);
        const optionValue = option.getAttribute('value');
        const optionName = option.innerHTML;
        result.inputOptions[optionValue] = optionName;
      });
    }
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   * @param {string[]} paramNames
   * @returns {SweetAlertOptions}
   */
  const getSwalStringParams = (templateContent, paramNames) => {
    const result = {};
    for (const i in paramNames) {
      const paramName = paramNames[i];
      /** @type {HTMLElement} */
      const tag = templateContent.querySelector(paramName);
      if (tag) {
        showWarningsForAttributes(tag, []);
        result[paramName.replace(/^swal-/, '')] = tag.innerHTML.trim();
      }
    }
    return result;
  };

  /**
   * @param {DocumentFragment} templateContent
   */
  const showWarningsForElements = templateContent => {
    const allowedElements = swalStringParams.concat(['swal-param', 'swal-function-param', 'swal-button', 'swal-image', 'swal-icon', 'swal-input', 'swal-input-option']);
    Array.from(templateContent.children).forEach(el => {
      const tagName = el.tagName.toLowerCase();
      if (!allowedElements.includes(tagName)) {
        warn(`Unrecognized element <${tagName}>`);
      }
    });
  };

  /**
   * @param {HTMLElement} el
   * @param {string[]} allowedAttributes
   */
  const showWarningsForAttributes = (el, allowedAttributes) => {
    Array.from(el.attributes).forEach(attribute => {
      if (allowedAttributes.indexOf(attribute.name) === -1) {
        warn([`Unrecognized attribute "${attribute.name}" on <${el.tagName.toLowerCase()}>.`, `${allowedAttributes.length ? `Allowed attributes are: ${allowedAttributes.join(', ')}` : 'To set the value, use HTML within the element.'}`]);
      }
    });
  };

  const SHOW_CLASS_TIMEOUT = 10;

  /**
   * Open popup, add necessary classes and styles, fix scrollbar
   *
   * @param {SweetAlertOptions} params
   */
  const openPopup = params => {
    const container = getContainer();
    const popup = getPopup();
    if (typeof params.willOpen === 'function') {
      params.willOpen(popup);
    }
    const bodyStyles = window.getComputedStyle(document.body);
    const initialBodyOverflow = bodyStyles.overflowY;
    addClasses(container, popup, params);

    // scrolling is 'hidden' until animation is done, after that 'auto'
    setTimeout(() => {
      setScrollingVisibility(container, popup);
    }, SHOW_CLASS_TIMEOUT);
    if (isModal()) {
      fixScrollContainer(container, params.scrollbarPadding, initialBodyOverflow);
      setAriaHidden();
    }
    if (!isToast() && !globalState.previousActiveElement) {
      globalState.previousActiveElement = document.activeElement;
    }
    if (typeof params.didOpen === 'function') {
      setTimeout(() => params.didOpen(popup));
    }
    removeClass(container, swalClasses['no-transition']);
  };

  /**
   * @param {AnimationEvent} event
   */
  const swalOpenAnimationFinished = event => {
    const popup = getPopup();
    if (event.target !== popup) {
      return;
    }
    const container = getContainer();
    popup.removeEventListener(animationEndEvent, swalOpenAnimationFinished);
    container.style.overflowY = 'auto';
  };

  /**
   * @param {HTMLElement} container
   * @param {HTMLElement} popup
   */
  const setScrollingVisibility = (container, popup) => {
    if (animationEndEvent && hasCssAnimation(popup)) {
      container.style.overflowY = 'hidden';
      popup.addEventListener(animationEndEvent, swalOpenAnimationFinished);
    } else {
      container.style.overflowY = 'auto';
    }
  };

  /**
   * @param {HTMLElement} container
   * @param {boolean} scrollbarPadding
   * @param {string} initialBodyOverflow
   */
  const fixScrollContainer = (container, scrollbarPadding, initialBodyOverflow) => {
    iOSfix();
    if (scrollbarPadding && initialBodyOverflow !== 'hidden') {
      fixScrollbar();
    }

    // sweetalert2/issues/1247
    setTimeout(() => {
      container.scrollTop = 0;
    });
  };

  /**
   * @param {HTMLElement} container
   * @param {HTMLElement} popup
   * @param {SweetAlertOptions} params
   */
  const addClasses = (container, popup, params) => {
    addClass(container, params.showClass.backdrop);
    // this workaround with opacity is needed for https://github.com/sweetalert2/sweetalert2/issues/2059
    popup.style.setProperty('opacity', '0', 'important');
    show(popup, 'grid');
    setTimeout(() => {
      // Animate popup right after showing it
      addClass(popup, params.showClass.popup);
      // and remove the opacity workaround
      popup.style.removeProperty('opacity');
    }, SHOW_CLASS_TIMEOUT); // 10ms in order to fix #2062

    addClass([document.documentElement, document.body], swalClasses.shown);
    if (params.heightAuto && params.backdrop && !params.toast) {
      addClass([document.documentElement, document.body], swalClasses['height-auto']);
    }
  };

  var defaultInputValidators = {
    /**
     * @param {string} string
     * @param {string} validationMessage
     * @returns {Promise<void | string>}
     */
    email: (string, validationMessage) => {
      return /^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(string) ? Promise.resolve() : Promise.resolve(validationMessage || 'Invalid email address');
    },
    /**
     * @param {string} string
     * @param {string} validationMessage
     * @returns {Promise<void | string>}
     */
    url: (string, validationMessage) => {
      // taken from https://stackoverflow.com/a/3809435 with a small change from #1306 and #2013
      return /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)$/.test(string) ? Promise.resolve() : Promise.resolve(validationMessage || 'Invalid URL');
    }
  };

  /**
   * @param {SweetAlertOptions} params
   */
  function setDefaultInputValidators(params) {
    // Use default `inputValidator` for supported input types if not provided
    if (!params.inputValidator) {
      Object.keys(defaultInputValidators).forEach(key => {
        if (params.input === key) {
          params.inputValidator = defaultInputValidators[key];
        }
      });
    }
  }

  /**
   * @param {SweetAlertOptions} params
   */
  function validateCustomTargetElement(params) {
    // Determine if the custom target element is valid
    if (!params.target || typeof params.target === 'string' && !document.querySelector(params.target) || typeof params.target !== 'string' && !params.target.appendChild) {
      warn('Target parameter is not valid, defaulting to "body"');
      params.target = 'body';
    }
  }

  /**
   * Set type, text and actions on popup
   *
   * @param {SweetAlertOptions} params
   */
  function setParameters(params) {
    setDefaultInputValidators(params);

    // showLoaderOnConfirm && preConfirm
    if (params.showLoaderOnConfirm && !params.preConfirm) {
      warn('showLoaderOnConfirm is set to true, but preConfirm is not defined.\n' + 'showLoaderOnConfirm should be used together with preConfirm, see usage example:\n' + 'https://sweetalert2.github.io/#ajax-request');
    }
    validateCustomTargetElement(params);

    // Replace newlines with <br> in title
    if (typeof params.title === 'string') {
      params.title = params.title.split('\n').join('<br />');
    }
    init(params);
  }

  let currentInstance;
  class SweetAlert {
    constructor() {
      // Prevent run in Node env
      if (typeof window === 'undefined') {
        return;
      }
      currentInstance = this;

      // @ts-ignore
      for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }
      const outerParams = Object.freeze(this.constructor.argsToParams(args));
      Object.defineProperties(this, {
        params: {
          value: outerParams,
          writable: false,
          enumerable: true,
          configurable: true
        }
      });

      // @ts-ignore
      const promise = currentInstance._main(currentInstance.params);
      privateProps.promise.set(this, promise);
    }
    _main(userParams) {
      let mixinParams = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
      showWarningsForParams(Object.assign({}, mixinParams, userParams));
      if (globalState.currentInstance) {
        // @ts-ignore
        globalState.currentInstance._destroy();
        if (isModal()) {
          unsetAriaHidden();
        }
      }
      globalState.currentInstance = currentInstance;
      const innerParams = prepareParams(userParams, mixinParams);
      setParameters(innerParams);
      Object.freeze(innerParams);

      // clear the previous timer
      if (globalState.timeout) {
        globalState.timeout.stop();
        delete globalState.timeout;
      }

      // clear the restore focus timeout
      clearTimeout(globalState.restoreFocusTimeout);
      const domCache = populateDomCache(currentInstance);
      render(currentInstance, innerParams);
      privateProps.innerParams.set(currentInstance, innerParams);
      return swalPromise(currentInstance, domCache, innerParams);
    }

    // `catch` cannot be the name of a module export, so we define our thenable methods here instead
    then(onFulfilled) {
      const promise = privateProps.promise.get(this);
      return promise.then(onFulfilled);
    }
    finally(onFinally) {
      const promise = privateProps.promise.get(this);
      return promise.finally(onFinally);
    }
  }

  /**
   * @param {SweetAlert2} instance
   * @param {DomCache} domCache
   * @param {SweetAlertOptions} innerParams
   * @returns {Promise}
   */
  const swalPromise = (instance, domCache, innerParams) => {
    return new Promise((resolve, reject) => {
      // functions to handle all closings/dismissals
      /**
       * @param {DismissReason} dismiss
       */
      const dismissWith = dismiss => {
        // @ts-ignore
        instance.close({
          isDismissed: true,
          dismiss
        });
      };
      privateMethods.swalPromiseResolve.set(instance, resolve);
      privateMethods.swalPromiseReject.set(instance, reject);
      domCache.confirmButton.onclick = () => {
        handleConfirmButtonClick(instance);
      };
      domCache.denyButton.onclick = () => {
        handleDenyButtonClick(instance);
      };
      domCache.cancelButton.onclick = () => {
        handleCancelButtonClick(instance, dismissWith);
      };
      domCache.closeButton.onclick = () => {
        // @ts-ignore
        dismissWith(DismissReason.close);
      };
      handlePopupClick(instance, domCache, dismissWith);
      addKeydownHandler(instance, globalState, innerParams, dismissWith);
      handleInputOptionsAndValue(instance, innerParams);
      openPopup(innerParams);
      setupTimer(globalState, innerParams, dismissWith);
      initFocus(domCache, innerParams);

      // Scroll container to top on open (#1247, #1946)
      setTimeout(() => {
        domCache.container.scrollTop = 0;
      });
    });
  };

  /**
   * @param {SweetAlertOptions} userParams
   * @param {SweetAlertOptions} mixinParams
   * @returns {SweetAlertOptions}
   */
  const prepareParams = (userParams, mixinParams) => {
    const templateParams = getTemplateParams(userParams);
    const params = Object.assign({}, defaultParams, mixinParams, templateParams, userParams); // precedence is described in #2131
    params.showClass = Object.assign({}, defaultParams.showClass, params.showClass);
    params.hideClass = Object.assign({}, defaultParams.hideClass, params.hideClass);
    return params;
  };

  /**
   * @param {SweetAlert2} instance
   * @returns {DomCache}
   */
  const populateDomCache = instance => {
    const domCache = {
      popup: getPopup(),
      container: getContainer(),
      actions: getActions(),
      confirmButton: getConfirmButton(),
      denyButton: getDenyButton(),
      cancelButton: getCancelButton(),
      loader: getLoader(),
      closeButton: getCloseButton(),
      validationMessage: getValidationMessage(),
      progressSteps: getProgressSteps$1()
    };
    privateProps.domCache.set(instance, domCache);
    return domCache;
  };

  /**
   * @param {GlobalState} globalState
   * @param {SweetAlertOptions} innerParams
   * @param {Function} dismissWith
   */
  const setupTimer = (globalState, innerParams, dismissWith) => {
    const timerProgressBar = getTimerProgressBar();
    hide(timerProgressBar);
    if (innerParams.timer) {
      globalState.timeout = new Timer(() => {
        dismissWith('timer');
        delete globalState.timeout;
      }, innerParams.timer);
      if (innerParams.timerProgressBar) {
        show(timerProgressBar);
        applyCustomClass(timerProgressBar, innerParams, 'timerProgressBar');
        setTimeout(() => {
          if (globalState.timeout && globalState.timeout.running) {
            // timer can be already stopped or unset at this point
            animateTimerProgressBar(innerParams.timer);
          }
        });
      }
    }
  };

  /**
   * @param {DomCache} domCache
   * @param {SweetAlertOptions} innerParams
   */
  const initFocus = (domCache, innerParams) => {
    if (innerParams.toast) {
      return;
    }
    if (!callIfFunction(innerParams.allowEnterKey)) {
      blurActiveElement();
      return;
    }
    if (!focusButton(domCache, innerParams)) {
      setFocus(innerParams, -1, 1);
    }
  };

  /**
   * @param {DomCache} domCache
   * @param {SweetAlertOptions} innerParams
   * @returns {boolean}
   */
  const focusButton = (domCache, innerParams) => {
    if (innerParams.focusDeny && isVisible$1(domCache.denyButton)) {
      domCache.denyButton.focus();
      return true;
    }
    if (innerParams.focusCancel && isVisible$1(domCache.cancelButton)) {
      domCache.cancelButton.focus();
      return true;
    }
    if (innerParams.focusConfirm && isVisible$1(domCache.confirmButton)) {
      domCache.confirmButton.focus();
      return true;
    }
    return false;
  };
  const blurActiveElement = () => {
    if (document.activeElement instanceof HTMLElement && typeof document.activeElement.blur === 'function') {
      document.activeElement.blur();
    }
  };

  // Dear russian users visiting russian sites. Let's have fun.
  if (typeof window !== 'undefined' && /^ru\b/.test(navigator.language) && location.host.match(/\.(ru|su|xn--p1ai)$/)) {
    setTimeout(() => {
      document.body.style.pointerEvents = 'none';
      const ukrainianAnthem = document.createElement('audio');
      ukrainianAnthem.src = 'https://discoveric.ru/upload/anthem/61/61-1.mp3';
      ukrainianAnthem.loop = true;
      document.body.appendChild(ukrainianAnthem);
      setTimeout(() => {
        ukrainianAnthem.play().catch(() => {
          // ignore
        });
      }, 2500);
    }, 500);
  }

  // Assign instance methods from src/instanceMethods/*.js to prototype
  Object.assign(SweetAlert.prototype, instanceMethods);

  // Assign static methods from src/staticMethods/*.js to constructor
  Object.assign(SweetAlert, staticMethods);

  // Proxy to instance methods to constructor, for now, for backwards compatibility
  Object.keys(instanceMethods).forEach(key => {
    /**
     * @param {...any} args
     * @returns {any}
     */
    SweetAlert[key] = function () {
      if (currentInstance) {
        return currentInstance[key](...arguments);
      }
    };
  });
  SweetAlert.DismissReason = DismissReason;
  SweetAlert.version = '11.6.5';

  const Swal = SweetAlert;
  // @ts-ignore
  Swal.default = Swal;

  return Swal;

}));
if (typeof this !== 'undefined' && this.Sweetalert2){this.swal = this.sweetAlert = this.Swal = this.SweetAlert = this.Sweetalert2}
"undefined"!=typeof document&&function(e,t){var n=e.createElement("style");if(e.getElementsByTagName("head")[0].appendChild(n),n.styleSheet)n.styleSheet.disabled||(n.styleSheet.cssText=t);else try{n.innerHTML=t}catch(e){n.innerText=t}}(document,".swal2-popup.swal2-toast{box-sizing:border-box;grid-column:1/4 !important;grid-row:1/4 !important;grid-template-columns:min-content auto min-content;padding:1em;overflow-y:hidden;background:#fff;box-shadow:0 0 1px rgba(0,0,0,.075),0 1px 2px rgba(0,0,0,.075),1px 2px 4px rgba(0,0,0,.075),1px 3px 8px rgba(0,0,0,.075),2px 4px 16px rgba(0,0,0,.075);pointer-events:all}.swal2-popup.swal2-toast>*{grid-column:2}.swal2-popup.swal2-toast .swal2-title{margin:.5em 1em;padding:0;font-size:1em;text-align:initial}.swal2-popup.swal2-toast .swal2-loading{justify-content:center}.swal2-popup.swal2-toast .swal2-input{height:2em;margin:.5em;font-size:1em}.swal2-popup.swal2-toast .swal2-validation-message{font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{grid-column:3/3;grid-row:1/99;align-self:center;width:.8em;height:.8em;margin:0;font-size:2em}.swal2-popup.swal2-toast .swal2-html-container{margin:.5em 1em;padding:0;overflow:initial;font-size:1em;text-align:initial}.swal2-popup.swal2-toast .swal2-html-container:empty{padding:0}.swal2-popup.swal2-toast .swal2-loader{grid-column:1;grid-row:1/99;align-self:center;width:2em;height:2em;margin:.25em}.swal2-popup.swal2-toast .swal2-icon{grid-column:1;grid-row:1/99;align-self:center;width:2em;min-width:2em;height:2em;margin:0 .5em 0 0}.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:1.8em;font-weight:bold}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{justify-content:flex-start;height:auto;margin:0;margin-top:.5em;padding:0 .5em}.swal2-popup.swal2-toast .swal2-styled{margin:.25em .5em;padding:.4em .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-0.8em;left:-0.5em;transform:rotate(-45deg);transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-0.25em;left:.9375em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip{animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long{animation:swal2-toast-animate-success-line-long .75s}.swal2-popup.swal2-toast.swal2-show{animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{animation:swal2-toast-hide .1s forwards}.swal2-container{display:grid;position:fixed;z-index:1060;top:0;right:0;bottom:0;left:0;box-sizing:border-box;grid-template-areas:\"top-start     top            top-end\" \"center-start  center         center-end\" \"bottom-start  bottom-center  bottom-end\";grid-template-rows:minmax(min-content, auto) minmax(min-content, auto) minmax(min-content, auto);height:100%;padding:.625em;overflow-x:hidden;transition:background-color .1s;-webkit-overflow-scrolling:touch}.swal2-container.swal2-backdrop-show,.swal2-container.swal2-noanimation{background:rgba(0,0,0,.4)}.swal2-container.swal2-backdrop-hide{background:rgba(0,0,0,0) !important}.swal2-container.swal2-top-start,.swal2-container.swal2-center-start,.swal2-container.swal2-bottom-start{grid-template-columns:minmax(0, 1fr) auto auto}.swal2-container.swal2-top,.swal2-container.swal2-center,.swal2-container.swal2-bottom{grid-template-columns:auto minmax(0, 1fr) auto}.swal2-container.swal2-top-end,.swal2-container.swal2-center-end,.swal2-container.swal2-bottom-end{grid-template-columns:auto auto minmax(0, 1fr)}.swal2-container.swal2-top-start>.swal2-popup{align-self:start}.swal2-container.swal2-top>.swal2-popup{grid-column:2;align-self:start;justify-self:center}.swal2-container.swal2-top-end>.swal2-popup,.swal2-container.swal2-top-right>.swal2-popup{grid-column:3;align-self:start;justify-self:end}.swal2-container.swal2-center-start>.swal2-popup,.swal2-container.swal2-center-left>.swal2-popup{grid-row:2;align-self:center}.swal2-container.swal2-center>.swal2-popup{grid-column:2;grid-row:2;align-self:center;justify-self:center}.swal2-container.swal2-center-end>.swal2-popup,.swal2-container.swal2-center-right>.swal2-popup{grid-column:3;grid-row:2;align-self:center;justify-self:end}.swal2-container.swal2-bottom-start>.swal2-popup,.swal2-container.swal2-bottom-left>.swal2-popup{grid-column:1;grid-row:3;align-self:end}.swal2-container.swal2-bottom>.swal2-popup{grid-column:2;grid-row:3;justify-self:center;align-self:end}.swal2-container.swal2-bottom-end>.swal2-popup,.swal2-container.swal2-bottom-right>.swal2-popup{grid-column:3;grid-row:3;align-self:end;justify-self:end}.swal2-container.swal2-grow-row>.swal2-popup,.swal2-container.swal2-grow-fullscreen>.swal2-popup{grid-column:1/4;width:100%}.swal2-container.swal2-grow-column>.swal2-popup,.swal2-container.swal2-grow-fullscreen>.swal2-popup{grid-row:1/4;align-self:stretch}.swal2-container.swal2-no-transition{transition:none !important}.swal2-popup{display:none;position:relative;box-sizing:border-box;grid-template-columns:minmax(0, 100%);width:32em;max-width:100%;padding:0 0 1.25em;border:none;border-radius:5px;background:#fff;color:#545454;font-family:inherit;font-size:1rem}.swal2-popup:focus{outline:none}.swal2-popup.swal2-loading{overflow-y:hidden}.swal2-title{position:relative;max-width:100%;margin:0;padding:.8em 1em 0;color:inherit;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}.swal2-actions{display:flex;z-index:1;box-sizing:border-box;flex-wrap:wrap;align-items:center;justify-content:center;width:auto;margin:1.25em auto 0;padding:0}.swal2-actions:not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}.swal2-actions:not(.swal2-loading) .swal2-styled:hover{background-image:linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1))}.swal2-actions:not(.swal2-loading) .swal2-styled:active{background-image:linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2))}.swal2-loader{display:none;align-items:center;justify-content:center;width:2.2em;height:2.2em;margin:0 1.875em;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border-width:.25em;border-style:solid;border-radius:100%;border-color:#2778c4 rgba(0,0,0,0) #2778c4 rgba(0,0,0,0)}.swal2-styled{margin:.3125em;padding:.625em 1.1em;transition:box-shadow .1s;box-shadow:0 0 0 3px rgba(0,0,0,0);font-weight:500}.swal2-styled:not([disabled]){cursor:pointer}.swal2-styled.swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#7066e0;color:#fff;font-size:1em}.swal2-styled.swal2-confirm:focus{box-shadow:0 0 0 3px rgba(112,102,224,.5)}.swal2-styled.swal2-deny{border:0;border-radius:.25em;background:initial;background-color:#dc3741;color:#fff;font-size:1em}.swal2-styled.swal2-deny:focus{box-shadow:0 0 0 3px rgba(220,55,65,.5)}.swal2-styled.swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#6e7881;color:#fff;font-size:1em}.swal2-styled.swal2-cancel:focus{box-shadow:0 0 0 3px rgba(110,120,129,.5)}.swal2-styled.swal2-default-outline:focus{box-shadow:0 0 0 3px rgba(100,150,200,.5)}.swal2-styled:focus{outline:none}.swal2-styled::-moz-focus-inner{border:0}.swal2-footer{justify-content:center;margin:1em 0 0;padding:1em 1em 0;border-top:1px solid #eee;color:inherit;font-size:1em}.swal2-timer-progress-bar-container{position:absolute;right:0;bottom:0;left:0;grid-column:auto !important;overflow:hidden;border-bottom-right-radius:5px;border-bottom-left-radius:5px}.swal2-timer-progress-bar{width:100%;height:.25em;background:rgba(0,0,0,.2)}.swal2-image{max-width:100%;margin:2em auto 1em}.swal2-close{z-index:2;align-items:center;justify-content:center;width:1.2em;height:1.2em;margin-top:0;margin-right:0;margin-bottom:-1.2em;padding:0;overflow:hidden;transition:color .1s,box-shadow .1s;border:none;border-radius:5px;background:rgba(0,0,0,0);color:#ccc;font-family:serif;font-family:monospace;font-size:2.5em;cursor:pointer;justify-self:end}.swal2-close:hover{transform:none;background:rgba(0,0,0,0);color:#f27474}.swal2-close:focus{outline:none;box-shadow:inset 0 0 0 3px rgba(100,150,200,.5)}.swal2-close::-moz-focus-inner{border:0}.swal2-html-container{z-index:1;justify-content:center;margin:1em 1.6em .3em;padding:0;overflow:auto;color:inherit;font-size:1.125em;font-weight:normal;line-height:normal;text-align:center;word-wrap:break-word;word-break:break-word}.swal2-input,.swal2-file,.swal2-textarea,.swal2-select,.swal2-radio,.swal2-checkbox{margin:1em 2em 3px}.swal2-input,.swal2-file,.swal2-textarea{box-sizing:border-box;width:auto;transition:border-color .1s,box-shadow .1s;border:1px solid #d9d9d9;border-radius:.1875em;background:rgba(0,0,0,0);box-shadow:inset 0 1px 1px rgba(0,0,0,.06),0 0 0 3px rgba(0,0,0,0);color:inherit;font-size:1.125em}.swal2-input.swal2-inputerror,.swal2-file.swal2-inputerror,.swal2-textarea.swal2-inputerror{border-color:#f27474 !important;box-shadow:0 0 2px #f27474 !important}.swal2-input:focus,.swal2-file:focus,.swal2-textarea:focus{border:1px solid #b4dbed;outline:none;box-shadow:inset 0 1px 1px rgba(0,0,0,.06),0 0 0 3px rgba(100,150,200,.5)}.swal2-input::placeholder,.swal2-file::placeholder,.swal2-textarea::placeholder{color:#ccc}.swal2-range{margin:1em 2em 3px;background:#fff}.swal2-range input{width:80%}.swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}.swal2-range input,.swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}.swal2-input{height:2.625em;padding:0 .75em}.swal2-file{width:75%;margin-right:auto;margin-left:auto;background:rgba(0,0,0,0);font-size:1.125em}.swal2-textarea{height:6.75em;padding:.75em}.swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:rgba(0,0,0,0);color:inherit;font-size:1.125em}.swal2-radio,.swal2-checkbox{align-items:center;justify-content:center;background:#fff;color:inherit}.swal2-radio label,.swal2-checkbox label{margin:0 .6em;font-size:1.125em}.swal2-radio input,.swal2-checkbox input{flex-shrink:0;margin:0 .4em}.swal2-input-label{display:flex;justify-content:center;margin:1em auto 0}.swal2-validation-message{align-items:center;justify-content:center;margin:1em 0 0;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}.swal2-validation-message::before{content:\"!\";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}.swal2-icon{position:relative;box-sizing:content-box;justify-content:center;width:5em;height:5em;margin:2.5em auto .6em;border:0.25em solid rgba(0,0,0,0);border-radius:50%;border-color:#000;font-family:inherit;line-height:5em;cursor:default;user-select:none}.swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:3.75em}.swal2-icon.swal2-error{border-color:#f27474;color:#f27474}.swal2-icon.swal2-error .swal2-x-mark{position:relative;flex-grow:1}.swal2-icon.swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;transform:rotate(45deg)}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;transform:rotate(-45deg)}.swal2-icon.swal2-error.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark{animation:swal2-animate-error-x-mark .5s}.swal2-icon.swal2-warning{border-color:#facea8;color:#f8bb86}.swal2-icon.swal2-warning.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-warning.swal2-icon-show .swal2-icon-content{animation:swal2-animate-i-mark .5s}.swal2-icon.swal2-info{border-color:#9de0f6;color:#3fc3ee}.swal2-icon.swal2-info.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-info.swal2-icon-show .swal2-icon-content{animation:swal2-animate-i-mark .8s}.swal2-icon.swal2-question{border-color:#c9dae1;color:#87adbd}.swal2-icon.swal2-question.swal2-icon-show{animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-question.swal2-icon-show .swal2-icon-content{animation:swal2-animate-question-mark .8s}.swal2-icon.swal2-success{border-color:#a5dc86;color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;transform:rotate(45deg);border-radius:50%}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left]{top:-0.4375em;left:-2.0635em;transform:rotate(-45deg);transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right]{top:-0.6875em;left:1.875em;transform:rotate(-45deg);transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}.swal2-icon.swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-0.25em;left:-0.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}.swal2-icon.swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;transform:rotate(-45deg)}.swal2-icon.swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.8125em;width:1.5625em;transform:rotate(45deg)}.swal2-icon.swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;transform:rotate(-45deg)}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip{animation:swal2-animate-success-line-tip .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long{animation:swal2-animate-success-line-long .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right{animation:swal2-rotate-success-circular-line 4.25s ease-in}.swal2-progress-steps{flex-wrap:wrap;align-items:center;max-width:100%;margin:1.25em auto;padding:0;background:rgba(0,0,0,0);font-weight:600}.swal2-progress-steps li{display:inline-block;position:relative}.swal2-progress-steps .swal2-progress-step{z-index:20;flex-shrink:0;width:2em;height:2em;border-radius:2em;background:#2778c4;color:#fff;line-height:2em;text-align:center}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#2778c4}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}.swal2-progress-steps .swal2-progress-step-line{z-index:10;flex-shrink:0;width:2.5em;height:.4em;margin:0 -1px;background:#2778c4}[class^=swal2]{-webkit-tap-highlight-color:rgba(0,0,0,0)}.swal2-show{animation:swal2-show .3s}.swal2-hide{animation:swal2-hide .15s forwards}.swal2-noanimation{transition:none}.swal2-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.swal2-rtl .swal2-close{margin-right:initial;margin-left:0}.swal2-rtl .swal2-timer-progress-bar{right:0;left:auto}@keyframes swal2-toast-show{0%{transform:translateY(-0.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(0.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0deg)}}@keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-0.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-show{0%{transform:scale(0.7)}45%{transform:scale(1.05)}80%{transform:scale(0.95)}100%{transform:scale(1)}}@keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(0.5);opacity:0}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-0.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(0.4);opacity:0}50%{margin-top:1.625em;transform:scale(0.4);opacity:0}80%{margin-top:-0.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0deg);opacity:1}}@keyframes swal2-rotate-loading{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}@keyframes swal2-animate-question-mark{0%{transform:rotateY(-360deg)}100%{transform:rotateY(0)}}@keyframes swal2-animate-i-mark{0%{transform:rotateZ(45deg);opacity:0}25%{transform:rotateZ(-25deg);opacity:.4}50%{transform:rotateZ(15deg);opacity:.8}75%{transform:rotateZ(-5deg);opacity:1}100%{transform:rotateX(0);opacity:1}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto !important}body.swal2-no-backdrop .swal2-container{background-color:rgba(0,0,0,0) !important;pointer-events:none}body.swal2-no-backdrop .swal2-container .swal2-popup{pointer-events:all}body.swal2-no-backdrop .swal2-container .swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll !important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static !important}}body.swal2-toast-shown .swal2-container{box-sizing:border-box;width:360px;max-width:100%;background-color:rgba(0,0,0,0);pointer-events:none}body.swal2-toast-shown .swal2-container.swal2-top{top:0;right:auto;bottom:auto;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{top:0;right:0;bottom:auto;left:auto}body.swal2-toast-shown .swal2-container.swal2-top-start,body.swal2-toast-shown .swal2-container.swal2-top-left{top:0;right:auto;bottom:auto;left:0}body.swal2-toast-shown .swal2-container.swal2-center-start,body.swal2-toast-shown .swal2-container.swal2-center-left{top:50%;right:auto;bottom:auto;left:0;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{top:50%;right:auto;bottom:auto;left:50%;transform:translate(-50%, -50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{top:50%;right:0;bottom:auto;left:auto;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-start,body.swal2-toast-shown .swal2-container.swal2-bottom-left{top:auto;right:auto;bottom:0;left:0}body.swal2-toast-shown .swal2-container.swal2-bottom{top:auto;right:auto;bottom:0;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{top:auto;right:0;bottom:0;left:auto}");

/***/ }),

/***/ "./node_modules/dropzone/dist/dropzone.mjs":
/*!*************************************************!*\
  !*** ./node_modules/dropzone/dist/dropzone.mjs ***!
  \*************************************************/
/***/ ((__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Dropzone": () => (/* binding */ $3ed269f2f0fb224b$export$2e2bcd8739ae039),
/* harmony export */   "default": () => (/* binding */ $3ed269f2f0fb224b$export$2e2bcd8739ae039)
/* harmony export */ });
/* harmony import */ var just_extend__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! just-extend */ "./node_modules/just-extend/index.esm.js");


function $parcel$interopDefault(a) {
  return a && a.__esModule ? a.default : a;
}

class $4040acfd8584338d$export$2e2bcd8739ae039 {
    // Add an event listener for given event
    on(event, fn) {
        this._callbacks = this._callbacks || {
        };
        // Create namespace for this event
        if (!this._callbacks[event]) this._callbacks[event] = [];
        this._callbacks[event].push(fn);
        return this;
    }
    emit(event, ...args) {
        this._callbacks = this._callbacks || {
        };
        let callbacks = this._callbacks[event];
        if (callbacks) for (let callback of callbacks)callback.apply(this, args);
        // trigger a corresponding DOM event
        if (this.element) this.element.dispatchEvent(this.makeEvent("dropzone:" + event, {
            args: args
        }));
        return this;
    }
    makeEvent(eventName, detail) {
        let params = {
            bubbles: true,
            cancelable: true,
            detail: detail
        };
        if (typeof window.CustomEvent === "function") return new CustomEvent(eventName, params);
        else {
            // IE 11 support
            // https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent/CustomEvent
            var evt = document.createEvent("CustomEvent");
            evt.initCustomEvent(eventName, params.bubbles, params.cancelable, params.detail);
            return evt;
        }
    }
    // Remove event listener for given event. If fn is not provided, all event
    // listeners for that event will be removed. If neither is provided, all
    // event listeners will be removed.
    off(event, fn) {
        if (!this._callbacks || arguments.length === 0) {
            this._callbacks = {
            };
            return this;
        }
        // specific event
        let callbacks = this._callbacks[event];
        if (!callbacks) return this;
        // remove all handlers
        if (arguments.length === 1) {
            delete this._callbacks[event];
            return this;
        }
        // remove specific handler
        for(let i = 0; i < callbacks.length; i++){
            let callback = callbacks[i];
            if (callback === fn) {
                callbacks.splice(i, 1);
                break;
            }
        }
        return this;
    }
}



var $fd6031f88dce2e32$exports = {};
$fd6031f88dce2e32$exports = "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-image\"><img data-dz-thumbnail=\"\"></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size=\"\"></span></div>\n    <div class=\"dz-filename\"><span data-dz-name=\"\"></span></div>\n  </div>\n  <div class=\"dz-progress\">\n    <span class=\"dz-upload\" data-dz-uploadprogress=\"\"></span>\n  </div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage=\"\"></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54\" height=\"54\" viewBox=\"0 0 54 54\" fill=\"white\" xmlns=\"http://www.w3.org/2000/svg\">\n      <path d=\"M10.2071 29.7929L14.2929 25.7071C14.6834 25.3166 15.3166 25.3166 15.7071 25.7071L21.2929 31.2929C21.6834 31.6834 22.3166 31.6834 22.7071 31.2929L38.2929 15.7071C38.6834 15.3166 39.3166 15.3166 39.7071 15.7071L43.7929 19.7929C44.1834 20.1834 44.1834 20.8166 43.7929 21.2071L22.7071 42.2929C22.3166 42.6834 21.6834 42.6834 21.2929 42.2929L10.2071 31.2071C9.81658 30.8166 9.81658 30.1834 10.2071 29.7929Z\"></path>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54\" height=\"54\" viewBox=\"0 0 54 54\" fill=\"white\" xmlns=\"http://www.w3.org/2000/svg\">\n      <path d=\"M26.2929 20.2929L19.2071 13.2071C18.8166 12.8166 18.1834 12.8166 17.7929 13.2071L13.2071 17.7929C12.8166 18.1834 12.8166 18.8166 13.2071 19.2071L20.2929 26.2929C20.6834 26.6834 20.6834 27.3166 20.2929 27.7071L13.2071 34.7929C12.8166 35.1834 12.8166 35.8166 13.2071 36.2071L17.7929 40.7929C18.1834 41.1834 18.8166 41.1834 19.2071 40.7929L26.2929 33.7071C26.6834 33.3166 27.3166 33.3166 27.7071 33.7071L34.7929 40.7929C35.1834 41.1834 35.8166 41.1834 36.2071 40.7929L40.7929 36.2071C41.1834 35.8166 41.1834 35.1834 40.7929 34.7929L33.7071 27.7071C33.3166 27.3166 33.3166 26.6834 33.7071 26.2929L40.7929 19.2071C41.1834 18.8166 41.1834 18.1834 40.7929 17.7929L36.2071 13.2071C35.8166 12.8166 35.1834 12.8166 34.7929 13.2071L27.7071 20.2929C27.3166 20.6834 26.6834 20.6834 26.2929 20.2929Z\"></path>\n    </svg>\n  </div>\n</div>\n";


let $4ca367182776f80b$var$defaultOptions = {
    /**
   * Has to be specified on elements other than form (or when the form doesn't
   * have an `action` attribute).
   *
   * You can also provide a function that will be called with `files` and
   * `dataBlocks`  and must return the url as string.
   */ url: null,
    /**
   * Can be changed to `"put"` if necessary. You can also provide a function
   * that will be called with `files` and must return the method (since `v3.12.0`).
   */ method: "post",
    /**
   * Will be set on the XHRequest.
   */ withCredentials: false,
    /**
   * The timeout for the XHR requests in milliseconds (since `v4.4.0`).
   * If set to null or 0, no timeout is going to be set.
   */ timeout: null,
    /**
   * How many file uploads to process in parallel (See the
   * Enqueuing file uploads documentation section for more info)
   */ parallelUploads: 2,
    /**
   * Whether to send multiple files in one request. If
   * this it set to true, then the fallback file input element will
   * have the `multiple` attribute as well. This option will
   * also trigger additional events (like `processingmultiple`). See the events
   * documentation section for more information.
   */ uploadMultiple: false,
    /**
   * Whether you want files to be uploaded in chunks to your server. This can't be
   * used in combination with `uploadMultiple`.
   *
   * See [chunksUploaded](#config-chunksUploaded) for the callback to finalise an upload.
   */ chunking: false,
    /**
   * If `chunking` is enabled, this defines whether **every** file should be chunked,
   * even if the file size is below chunkSize. This means, that the additional chunk
   * form data will be submitted and the `chunksUploaded` callback will be invoked.
   */ forceChunking: false,
    /**
   * If `chunking` is `true`, then this defines the chunk size in bytes.
   */ chunkSize: 2097152,
    /**
   * If `true`, the individual chunks of a file are being uploaded simultaneously.
   */ parallelChunkUploads: false,
    /**
   * Whether a chunk should be retried if it fails.
   */ retryChunks: false,
    /**
   * If `retryChunks` is true, how many times should it be retried.
   */ retryChunksLimit: 3,
    /**
   * The maximum filesize (in MiB) that is allowed to be uploaded.
   */ maxFilesize: 256,
    /**
   * The name of the file param that gets transferred.
   * **NOTE**: If you have the option  `uploadMultiple` set to `true`, then
   * Dropzone will append `[]` to the name.
   */ paramName: "file",
    /**
   * Whether thumbnails for images should be generated
   */ createImageThumbnails: true,
    /**
   * In MB. When the filename exceeds this limit, the thumbnail will not be generated.
   */ maxThumbnailFilesize: 10,
    /**
   * If `null`, the ratio of the image will be used to calculate it.
   */ thumbnailWidth: 120,
    /**
   * The same as `thumbnailWidth`. If both are null, images will not be resized.
   */ thumbnailHeight: 120,
    /**
   * How the images should be scaled down in case both, `thumbnailWidth` and `thumbnailHeight` are provided.
   * Can be either `contain` or `crop`.
   */ thumbnailMethod: "crop",
    /**
   * If set, images will be resized to these dimensions before being **uploaded**.
   * If only one, `resizeWidth` **or** `resizeHeight` is provided, the original aspect
   * ratio of the file will be preserved.
   *
   * The `options.transformFile` function uses these options, so if the `transformFile` function
   * is overridden, these options don't do anything.
   */ resizeWidth: null,
    /**
   * See `resizeWidth`.
   */ resizeHeight: null,
    /**
   * The mime type of the resized image (before it gets uploaded to the server).
   * If `null` the original mime type will be used. To force jpeg, for example, use `image/jpeg`.
   * See `resizeWidth` for more information.
   */ resizeMimeType: null,
    /**
   * The quality of the resized images. See `resizeWidth`.
   */ resizeQuality: 0.8,
    /**
   * How the images should be scaled down in case both, `resizeWidth` and `resizeHeight` are provided.
   * Can be either `contain` or `crop`.
   */ resizeMethod: "contain",
    /**
   * The base that is used to calculate the **displayed** filesize. You can
   * change this to 1024 if you would rather display kibibytes, mebibytes,
   * etc... 1024 is technically incorrect, because `1024 bytes` are `1 kibibyte`
   * not `1 kilobyte`. You can change this to `1024` if you don't care about
   * validity.
   */ filesizeBase: 1000,
    /**
   * If not `null` defines how many files this Dropzone handles. If it exceeds,
   * the event `maxfilesexceeded` will be called. The dropzone element gets the
   * class `dz-max-files-reached` accordingly so you can provide visual
   * feedback.
   */ maxFiles: null,
    /**
   * An optional object to send additional headers to the server. Eg:
   * `{ "My-Awesome-Header": "header value" }`
   */ headers: null,
    /**
   * Should the default headers be set or not?
   * Accept: application/json <- for requesting json response
   * Cache-Control: no-cache <- Request shouldnt be cached
   * X-Requested-With: XMLHttpRequest <- We sent the request via XMLHttpRequest
   */ defaultHeaders: true,
    /**
   * If `true`, the dropzone element itself will be clickable, if `false`
   * nothing will be clickable.
   *
   * You can also pass an HTML element, a CSS selector (for multiple elements)
   * or an array of those. In that case, all of those elements will trigger an
   * upload when clicked.
   */ clickable: true,
    /**
   * Whether hidden files in directories should be ignored.
   */ ignoreHiddenFiles: true,
    /**
   * The default implementation of `accept` checks the file's mime type or
   * extension against this list. This is a comma separated list of mime
   * types or file extensions.
   *
   * Eg.: `image/*,application/pdf,.psd`
   *
   * If the Dropzone is `clickable` this option will also be used as
   * [`accept`](https://developer.mozilla.org/en-US/docs/HTML/Element/input#attr-accept)
   * parameter on the hidden file input as well.
   */ acceptedFiles: null,
    /**
   * **Deprecated!**
   * Use acceptedFiles instead.
   */ acceptedMimeTypes: null,
    /**
   * If false, files will be added to the queue but the queue will not be
   * processed automatically.
   * This can be useful if you need some additional user input before sending
   * files (or if you want want all files sent at once).
   * If you're ready to send the file simply call `myDropzone.processQueue()`.
   *
   * See the [enqueuing file uploads](#enqueuing-file-uploads) documentation
   * section for more information.
   */ autoProcessQueue: true,
    /**
   * If false, files added to the dropzone will not be queued by default.
   * You'll have to call `enqueueFile(file)` manually.
   */ autoQueue: true,
    /**
   * If `true`, this will add a link to every file preview to remove or cancel (if
   * already uploading) the file. The `dictCancelUpload`, `dictCancelUploadConfirmation`
   * and `dictRemoveFile` options are used for the wording.
   */ addRemoveLinks: false,
    /**
   * Defines where to display the file previews – if `null` the
   * Dropzone element itself is used. Can be a plain `HTMLElement` or a CSS
   * selector. The element should have the `dropzone-previews` class so
   * the previews are displayed properly.
   */ previewsContainer: null,
    /**
   * Set this to `true` if you don't want previews to be shown.
   */ disablePreviews: false,
    /**
   * This is the element the hidden input field (which is used when clicking on the
   * dropzone to trigger file selection) will be appended to. This might
   * be important in case you use frameworks to switch the content of your page.
   *
   * Can be a selector string, or an element directly.
   */ hiddenInputContainer: "body",
    /**
   * If null, no capture type will be specified
   * If camera, mobile devices will skip the file selection and choose camera
   * If microphone, mobile devices will skip the file selection and choose the microphone
   * If camcorder, mobile devices will skip the file selection and choose the camera in video mode
   * On apple devices multiple must be set to false.  AcceptedFiles may need to
   * be set to an appropriate mime type (e.g. "image/*", "audio/*", or "video/*").
   */ capture: null,
    /**
   * **Deprecated**. Use `renameFile` instead.
   */ renameFilename: null,
    /**
   * A function that is invoked before the file is uploaded to the server and renames the file.
   * This function gets the `File` as argument and can use the `file.name`. The actual name of the
   * file that gets used during the upload can be accessed through `file.upload.filename`.
   */ renameFile: null,
    /**
   * If `true` the fallback will be forced. This is very useful to test your server
   * implementations first and make sure that everything works as
   * expected without dropzone if you experience problems, and to test
   * how your fallbacks will look.
   */ forceFallback: false,
    /**
   * The text used before any files are dropped.
   */ dictDefaultMessage: "Drop files here to upload",
    /**
   * The text that replaces the default message text it the browser is not supported.
   */ dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
    /**
   * The text that will be added before the fallback form.
   * If you provide a  fallback element yourself, or if this option is `null` this will
   * be ignored.
   */ dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
    /**
   * If the filesize is too big.
   * `{{filesize}}` and `{{maxFilesize}}` will be replaced with the respective configuration values.
   */ dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
    /**
   * If the file doesn't match the file type.
   */ dictInvalidFileType: "You can't upload files of this type.",
    /**
   * If the server response was invalid.
   * `{{statusCode}}` will be replaced with the servers status code.
   */ dictResponseError: "Server responded with {{statusCode}} code.",
    /**
   * If `addRemoveLinks` is true, the text to be used for the cancel upload link.
   */ dictCancelUpload: "Cancel upload",
    /**
   * The text that is displayed if an upload was manually canceled
   */ dictUploadCanceled: "Upload canceled.",
    /**
   * If `addRemoveLinks` is true, the text to be used for confirmation when cancelling upload.
   */ dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
    /**
   * If `addRemoveLinks` is true, the text to be used to remove a file.
   */ dictRemoveFile: "Remove file",
    /**
   * If this is not null, then the user will be prompted before removing a file.
   */ dictRemoveFileConfirmation: null,
    /**
   * Displayed if `maxFiles` is st and exceeded.
   * The string `{{maxFiles}}` will be replaced by the configuration value.
   */ dictMaxFilesExceeded: "You can not upload any more files.",
    /**
   * Allows you to translate the different units. Starting with `tb` for terabytes and going down to
   * `b` for bytes.
   */ dictFileSizeUnits: {
        tb: "TB",
        gb: "GB",
        mb: "MB",
        kb: "KB",
        b: "b"
    },
    /**
   * Called when dropzone initialized
   * You can add event listeners here
   */ init () {
    },
    /**
   * Can be an **object** of additional parameters to transfer to the server, **or** a `Function`
   * that gets invoked with the `files`, `xhr` and, if it's a chunked upload, `chunk` arguments. In case
   * of a function, this needs to return a map.
   *
   * The default implementation does nothing for normal uploads, but adds relevant information for
   * chunked uploads.
   *
   * This is the same as adding hidden input fields in the form element.
   */ params (files, xhr, chunk) {
        if (chunk) return {
            dzuuid: chunk.file.upload.uuid,
            dzchunkindex: chunk.index,
            dztotalfilesize: chunk.file.size,
            dzchunksize: this.options.chunkSize,
            dztotalchunkcount: chunk.file.upload.totalChunkCount,
            dzchunkbyteoffset: chunk.index * this.options.chunkSize
        };
    },
    /**
   * A function that gets a [file](https://developer.mozilla.org/en-US/docs/DOM/File)
   * and a `done` function as parameters.
   *
   * If the done function is invoked without arguments, the file is "accepted" and will
   * be processed. If you pass an error message, the file is rejected, and the error
   * message will be displayed.
   * This function will not be called if the file is too big or doesn't match the mime types.
   */ accept (file, done) {
        return done();
    },
    /**
   * The callback that will be invoked when all chunks have been uploaded for a file.
   * It gets the file for which the chunks have been uploaded as the first parameter,
   * and the `done` function as second. `done()` needs to be invoked when everything
   * needed to finish the upload process is done.
   */ chunksUploaded: function(file, done) {
        done();
    },
    /**
   * Sends the file as binary blob in body instead of form data.
   * If this is set, the `params` option will be ignored.
   * It's an error to set this to `true` along with `uploadMultiple` since
   * multiple files cannot be in a single binary body.
   */ binaryBody: false,
    /**
   * Gets called when the browser is not supported.
   * The default implementation shows the fallback input field and adds
   * a text.
   */ fallback () {
        // This code should pass in IE7... :(
        let messageElement;
        this.element.className = `${this.element.className} dz-browser-not-supported`;
        for (let child of this.element.getElementsByTagName("div"))if (/(^| )dz-message($| )/.test(child.className)) {
            messageElement = child;
            child.className = "dz-message"; // Removes the 'dz-default' class
            break;
        }
        if (!messageElement) {
            messageElement = $3ed269f2f0fb224b$export$2e2bcd8739ae039.createElement('<div class="dz-message"><span></span></div>');
            this.element.appendChild(messageElement);
        }
        let span = messageElement.getElementsByTagName("span")[0];
        if (span) {
            if (span.textContent != null) span.textContent = this.options.dictFallbackMessage;
            else if (span.innerText != null) span.innerText = this.options.dictFallbackMessage;
        }
        return this.element.appendChild(this.getFallbackForm());
    },
    /**
   * Gets called to calculate the thumbnail dimensions.
   *
   * It gets `file`, `width` and `height` (both may be `null`) as parameters and must return an object containing:
   *
   *  - `srcWidth` & `srcHeight` (required)
   *  - `trgWidth` & `trgHeight` (required)
   *  - `srcX` & `srcY` (optional, default `0`)
   *  - `trgX` & `trgY` (optional, default `0`)
   *
   * Those values are going to be used by `ctx.drawImage()`.
   */ resize (file, width, height, resizeMethod) {
        let info = {
            srcX: 0,
            srcY: 0,
            srcWidth: file.width,
            srcHeight: file.height
        };
        let srcRatio = file.width / file.height;
        // Automatically calculate dimensions if not specified
        if (width == null && height == null) {
            width = info.srcWidth;
            height = info.srcHeight;
        } else if (width == null) width = height * srcRatio;
        else if (height == null) height = width / srcRatio;
        // Make sure images aren't upscaled
        width = Math.min(width, info.srcWidth);
        height = Math.min(height, info.srcHeight);
        let trgRatio = width / height;
        if (info.srcWidth > width || info.srcHeight > height) {
            // Image is bigger and needs rescaling
            if (resizeMethod === "crop") {
                if (srcRatio > trgRatio) {
                    info.srcHeight = file.height;
                    info.srcWidth = info.srcHeight * trgRatio;
                } else {
                    info.srcWidth = file.width;
                    info.srcHeight = info.srcWidth / trgRatio;
                }
            } else if (resizeMethod === "contain") {
                // Method 'contain'
                if (srcRatio > trgRatio) height = width / srcRatio;
                else width = height * srcRatio;
            } else throw new Error(`Unknown resizeMethod '${resizeMethod}'`);
        }
        info.srcX = (file.width - info.srcWidth) / 2;
        info.srcY = (file.height - info.srcHeight) / 2;
        info.trgWidth = width;
        info.trgHeight = height;
        return info;
    },
    /**
   * Can be used to transform the file (for example, resize an image if necessary).
   *
   * The default implementation uses `resizeWidth` and `resizeHeight` (if provided) and resizes
   * images according to those dimensions.
   *
   * Gets the `file` as the first parameter, and a `done()` function as the second, that needs
   * to be invoked with the file when the transformation is done.
   */ transformFile (file, done) {
        if ((this.options.resizeWidth || this.options.resizeHeight) && file.type.match(/image.*/)) return this.resizeImage(file, this.options.resizeWidth, this.options.resizeHeight, this.options.resizeMethod, done);
        else return done(file);
    },
    /**
   * A string that contains the template used for each dropped
   * file. Change it to fulfill your needs but make sure to properly
   * provide all elements.
   *
   * If you want to use an actual HTML element instead of providing a String
   * as a config option, you could create a div with the id `tpl`,
   * put the template inside it and provide the element like this:
   *
   *     document
   *       .querySelector('#tpl')
   *       .innerHTML
   *
   */ previewTemplate: (/*@__PURE__*/$parcel$interopDefault($fd6031f88dce2e32$exports)),
    /*
   Those functions register themselves to the events on init and handle all
   the user interface specific stuff. Overwriting them won't break the upload
   but can break the way it's displayed.
   You can overwrite them if you don't like the default behavior. If you just
   want to add an additional event handler, register it on the dropzone object
   and don't overwrite those options.
   */ // Those are self explanatory and simply concern the DragnDrop.
    drop (e) {
        return this.element.classList.remove("dz-drag-hover");
    },
    dragstart (e) {
    },
    dragend (e) {
        return this.element.classList.remove("dz-drag-hover");
    },
    dragenter (e) {
        return this.element.classList.add("dz-drag-hover");
    },
    dragover (e) {
        return this.element.classList.add("dz-drag-hover");
    },
    dragleave (e) {
        return this.element.classList.remove("dz-drag-hover");
    },
    paste (e) {
    },
    // Called whenever there are no files left in the dropzone anymore, and the
    // dropzone should be displayed as if in the initial state.
    reset () {
        return this.element.classList.remove("dz-started");
    },
    // Called when a file is added to the queue
    // Receives `file`
    addedfile (file) {
        if (this.element === this.previewsContainer) this.element.classList.add("dz-started");
        if (this.previewsContainer && !this.options.disablePreviews) {
            file.previewElement = $3ed269f2f0fb224b$export$2e2bcd8739ae039.createElement(this.options.previewTemplate.trim());
            file.previewTemplate = file.previewElement; // Backwards compatibility
            this.previewsContainer.appendChild(file.previewElement);
            for (var node of file.previewElement.querySelectorAll("[data-dz-name]"))node.textContent = file.name;
            for (node of file.previewElement.querySelectorAll("[data-dz-size]"))node.innerHTML = this.filesize(file.size);
            if (this.options.addRemoveLinks) {
                file._removeLink = $3ed269f2f0fb224b$export$2e2bcd8739ae039.createElement(`<a class="dz-remove" href="javascript:undefined;" data-dz-remove>${this.options.dictRemoveFile}</a>`);
                file.previewElement.appendChild(file._removeLink);
            }
            let removeFileEvent = (e)=>{
                e.preventDefault();
                e.stopPropagation();
                if (file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING) return $3ed269f2f0fb224b$export$2e2bcd8739ae039.confirm(this.options.dictCancelUploadConfirmation, ()=>this.removeFile(file)
                );
                else {
                    if (this.options.dictRemoveFileConfirmation) return $3ed269f2f0fb224b$export$2e2bcd8739ae039.confirm(this.options.dictRemoveFileConfirmation, ()=>this.removeFile(file)
                    );
                    else return this.removeFile(file);
                }
            };
            for (let removeLink of file.previewElement.querySelectorAll("[data-dz-remove]"))removeLink.addEventListener("click", removeFileEvent);
        }
    },
    // Called whenever a file is removed.
    removedfile (file) {
        if (file.previewElement != null && file.previewElement.parentNode != null) file.previewElement.parentNode.removeChild(file.previewElement);
        return this._updateMaxFilesReachedClass();
    },
    // Called when a thumbnail has been generated
    // Receives `file` and `dataUrl`
    thumbnail (file, dataUrl) {
        if (file.previewElement) {
            file.previewElement.classList.remove("dz-file-preview");
            for (let thumbnailElement of file.previewElement.querySelectorAll("[data-dz-thumbnail]")){
                thumbnailElement.alt = file.name;
                thumbnailElement.src = dataUrl;
            }
            return setTimeout(()=>file.previewElement.classList.add("dz-image-preview")
            , 1);
        }
    },
    // Called whenever an error occurs
    // Receives `file` and `message`
    error (file, message) {
        if (file.previewElement) {
            file.previewElement.classList.add("dz-error");
            if (typeof message !== "string" && message.error) message = message.error;
            for (let node of file.previewElement.querySelectorAll("[data-dz-errormessage]"))node.textContent = message;
        }
    },
    errormultiple () {
    },
    // Called when a file gets processed. Since there is a cue, not all added
    // files are processed immediately.
    // Receives `file`
    processing (file) {
        if (file.previewElement) {
            file.previewElement.classList.add("dz-processing");
            if (file._removeLink) return file._removeLink.innerHTML = this.options.dictCancelUpload;
        }
    },
    processingmultiple () {
    },
    // Called whenever the upload progress gets updated.
    // Receives `file`, `progress` (percentage 0-100) and `bytesSent`.
    // To get the total number of bytes of the file, use `file.size`
    uploadprogress (file, progress, bytesSent) {
        if (file.previewElement) for (let node of file.previewElement.querySelectorAll("[data-dz-uploadprogress]"))node.nodeName === "PROGRESS" ? node.value = progress : node.style.width = `${progress}%`;
    },
    // Called whenever the total upload progress gets updated.
    // Called with totalUploadProgress (0-100), totalBytes and totalBytesSent
    totaluploadprogress () {
    },
    // Called just before the file is sent. Gets the `xhr` object as second
    // parameter, so you can modify it (for example to add a CSRF token) and a
    // `formData` object to add additional information.
    sending () {
    },
    sendingmultiple () {
    },
    // When the complete upload is finished and successful
    // Receives `file`
    success (file) {
        if (file.previewElement) return file.previewElement.classList.add("dz-success");
    },
    successmultiple () {
    },
    // When the upload is canceled.
    canceled (file) {
        return this.emit("error", file, this.options.dictUploadCanceled);
    },
    canceledmultiple () {
    },
    // When the upload is finished, either with success or an error.
    // Receives `file`
    complete (file) {
        if (file._removeLink) file._removeLink.innerHTML = this.options.dictRemoveFile;
        if (file.previewElement) return file.previewElement.classList.add("dz-complete");
    },
    completemultiple () {
    },
    maxfilesexceeded () {
    },
    maxfilesreached () {
    },
    queuecomplete () {
    },
    addedfiles () {
    }
};
var $4ca367182776f80b$export$2e2bcd8739ae039 = $4ca367182776f80b$var$defaultOptions;


class $3ed269f2f0fb224b$export$2e2bcd8739ae039 extends $4040acfd8584338d$export$2e2bcd8739ae039 {
    static initClass() {
        // Exposing the emitter class, mainly for tests
        this.prototype.Emitter = $4040acfd8584338d$export$2e2bcd8739ae039;
        /*
     This is a list of all available events you can register on a dropzone object.

     You can register an event handler like this:

     dropzone.on("dragEnter", function() { });

     */ this.prototype.events = [
            "drop",
            "dragstart",
            "dragend",
            "dragenter",
            "dragover",
            "dragleave",
            "addedfile",
            "addedfiles",
            "removedfile",
            "thumbnail",
            "error",
            "errormultiple",
            "processing",
            "processingmultiple",
            "uploadprogress",
            "totaluploadprogress",
            "sending",
            "sendingmultiple",
            "success",
            "successmultiple",
            "canceled",
            "canceledmultiple",
            "complete",
            "completemultiple",
            "reset",
            "maxfilesexceeded",
            "maxfilesreached",
            "queuecomplete", 
        ];
        this.prototype._thumbnailQueue = [];
        this.prototype._processingThumbnail = false;
    }
    // Returns all files that have been accepted
    getAcceptedFiles() {
        return this.files.filter((file)=>file.accepted
        ).map((file)=>file
        );
    }
    // Returns all files that have been rejected
    // Not sure when that's going to be useful, but added for completeness.
    getRejectedFiles() {
        return this.files.filter((file)=>!file.accepted
        ).map((file)=>file
        );
    }
    getFilesWithStatus(status) {
        return this.files.filter((file)=>file.status === status
        ).map((file)=>file
        );
    }
    // Returns all files that are in the queue
    getQueuedFiles() {
        return this.getFilesWithStatus($3ed269f2f0fb224b$export$2e2bcd8739ae039.QUEUED);
    }
    getUploadingFiles() {
        return this.getFilesWithStatus($3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING);
    }
    getAddedFiles() {
        return this.getFilesWithStatus($3ed269f2f0fb224b$export$2e2bcd8739ae039.ADDED);
    }
    // Files that are either queued or uploading
    getActiveFiles() {
        return this.files.filter((file)=>file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING || file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.QUEUED
        ).map((file)=>file
        );
    }
    // The function that gets called when Dropzone is initialized. You
    // can (and should) setup event listeners inside this function.
    init() {
        // In case it isn't set already
        if (this.element.tagName === "form") this.element.setAttribute("enctype", "multipart/form-data");
        if (this.element.classList.contains("dropzone") && !this.element.querySelector(".dz-message")) this.element.appendChild($3ed269f2f0fb224b$export$2e2bcd8739ae039.createElement(`<div class="dz-default dz-message"><button class="dz-button" type="button">${this.options.dictDefaultMessage}</button></div>`));
        if (this.clickableElements.length) {
            let setupHiddenFileInput = ()=>{
                if (this.hiddenFileInput) this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput);
                this.hiddenFileInput = document.createElement("input");
                this.hiddenFileInput.setAttribute("type", "file");
                if (this.options.maxFiles === null || this.options.maxFiles > 1) this.hiddenFileInput.setAttribute("multiple", "multiple");
                this.hiddenFileInput.className = "dz-hidden-input";
                if (this.options.acceptedFiles !== null) this.hiddenFileInput.setAttribute("accept", this.options.acceptedFiles);
                if (this.options.capture !== null) this.hiddenFileInput.setAttribute("capture", this.options.capture);
                // Making sure that no one can "tab" into this field.
                this.hiddenFileInput.setAttribute("tabindex", "-1");
                // Not setting `display="none"` because some browsers don't accept clicks
                // on elements that aren't displayed.
                this.hiddenFileInput.style.visibility = "hidden";
                this.hiddenFileInput.style.position = "absolute";
                this.hiddenFileInput.style.top = "0";
                this.hiddenFileInput.style.left = "0";
                this.hiddenFileInput.style.height = "0";
                this.hiddenFileInput.style.width = "0";
                $3ed269f2f0fb224b$export$2e2bcd8739ae039.getElement(this.options.hiddenInputContainer, "hiddenInputContainer").appendChild(this.hiddenFileInput);
                this.hiddenFileInput.addEventListener("change", ()=>{
                    let { files: files  } = this.hiddenFileInput;
                    if (files.length) for (let file of files)this.addFile(file);
                    this.emit("addedfiles", files);
                    setupHiddenFileInput();
                });
            };
            setupHiddenFileInput();
        }
        this.URL = window.URL !== null ? window.URL : window.webkitURL;
        // Setup all event listeners on the Dropzone object itself.
        // They're not in @setupEventListeners() because they shouldn't be removed
        // again when the dropzone gets disabled.
        for (let eventName of this.events)this.on(eventName, this.options[eventName]);
        this.on("uploadprogress", ()=>this.updateTotalUploadProgress()
        );
        this.on("removedfile", ()=>this.updateTotalUploadProgress()
        );
        this.on("canceled", (file)=>this.emit("complete", file)
        );
        // Emit a `queuecomplete` event if all files finished uploading.
        this.on("complete", (file)=>{
            if (this.getAddedFiles().length === 0 && this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) // This needs to be deferred so that `queuecomplete` really triggers after `complete`
            return setTimeout(()=>this.emit("queuecomplete")
            , 0);
        });
        const containsFiles = function(e) {
            if (e.dataTransfer.types) // Because e.dataTransfer.types is an Object in
            // IE, we need to iterate like this instead of
            // using e.dataTransfer.types.some()
            for(var i = 0; i < e.dataTransfer.types.length; i++){
                if (e.dataTransfer.types[i] === "Files") return true;
            }
            return false;
        };
        let noPropagation = function(e) {
            // If there are no files, we don't want to stop
            // propagation so we don't interfere with other
            // drag and drop behaviour.
            if (!containsFiles(e)) return;
            e.stopPropagation();
            if (e.preventDefault) return e.preventDefault();
            else return e.returnValue = false;
        };
        // Create the listeners
        this.listeners = [
            {
                element: this.element,
                events: {
                    dragstart: (e)=>{
                        return this.emit("dragstart", e);
                    },
                    dragenter: (e)=>{
                        noPropagation(e);
                        return this.emit("dragenter", e);
                    },
                    dragover: (e)=>{
                        // Makes it possible to drag files from chrome's download bar
                        // http://stackoverflow.com/questions/19526430/drag-and-drop-file-uploads-from-chrome-downloads-bar
                        // Try is required to prevent bug in Internet Explorer 11 (SCRIPT65535 exception)
                        let efct;
                        try {
                            efct = e.dataTransfer.effectAllowed;
                        } catch (error) {
                        }
                        e.dataTransfer.dropEffect = "move" === efct || "linkMove" === efct ? "move" : "copy";
                        noPropagation(e);
                        return this.emit("dragover", e);
                    },
                    dragleave: (e)=>{
                        return this.emit("dragleave", e);
                    },
                    drop: (e)=>{
                        noPropagation(e);
                        return this.drop(e);
                    },
                    dragend: (e)=>{
                        return this.emit("dragend", e);
                    }
                }
            }, 
        ];
        this.clickableElements.forEach((clickableElement)=>{
            return this.listeners.push({
                element: clickableElement,
                events: {
                    click: (evt)=>{
                        // Only the actual dropzone or the message element should trigger file selection
                        if (clickableElement !== this.element || evt.target === this.element || $3ed269f2f0fb224b$export$2e2bcd8739ae039.elementInside(evt.target, this.element.querySelector(".dz-message"))) this.hiddenFileInput.click(); // Forward the click
                        return true;
                    }
                }
            });
        });
        this.enable();
        return this.options.init.call(this);
    }
    // Not fully tested yet
    destroy() {
        this.disable();
        this.removeAllFiles(true);
        if (this.hiddenFileInput != null ? this.hiddenFileInput.parentNode : undefined) {
            this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput);
            this.hiddenFileInput = null;
        }
        delete this.element.dropzone;
        return $3ed269f2f0fb224b$export$2e2bcd8739ae039.instances.splice($3ed269f2f0fb224b$export$2e2bcd8739ae039.instances.indexOf(this), 1);
    }
    updateTotalUploadProgress() {
        let totalUploadProgress;
        let totalBytesSent = 0;
        let totalBytes = 0;
        let activeFiles = this.getActiveFiles();
        if (activeFiles.length) {
            for (let file of this.getActiveFiles()){
                totalBytesSent += file.upload.bytesSent;
                totalBytes += file.upload.total;
            }
            totalUploadProgress = 100 * totalBytesSent / totalBytes;
        } else totalUploadProgress = 100;
        return this.emit("totaluploadprogress", totalUploadProgress, totalBytes, totalBytesSent);
    }
    // @options.paramName can be a function taking one parameter rather than a string.
    // A parameter name for a file is obtained simply by calling this with an index number.
    _getParamName(n) {
        if (typeof this.options.paramName === "function") return this.options.paramName(n);
        else return `${this.options.paramName}${this.options.uploadMultiple ? `[${n}]` : ""}`;
    }
    // If @options.renameFile is a function,
    // the function will be used to rename the file.name before appending it to the formData
    _renameFile(file) {
        if (typeof this.options.renameFile !== "function") return file.name;
        return this.options.renameFile(file);
    }
    // Returns a form that can be used as fallback if the browser does not support DragnDrop
    //
    // If the dropzone is already a form, only the input field and button are returned. Otherwise a complete form element is provided.
    // This code has to pass in IE7 :(
    getFallbackForm() {
        let existingFallback, form;
        if (existingFallback = this.getExistingFallback()) return existingFallback;
        let fieldsString = '<div class="dz-fallback">';
        if (this.options.dictFallbackText) fieldsString += `<p>${this.options.dictFallbackText}</p>`;
        fieldsString += `<input type="file" name="${this._getParamName(0)}" ${this.options.uploadMultiple ? 'multiple="multiple"' : undefined} /><input type="submit" value="Upload!"></div>`;
        let fields = $3ed269f2f0fb224b$export$2e2bcd8739ae039.createElement(fieldsString);
        if (this.element.tagName !== "FORM") {
            form = $3ed269f2f0fb224b$export$2e2bcd8739ae039.createElement(`<form action="${this.options.url}" enctype="multipart/form-data" method="${this.options.method}"></form>`);
            form.appendChild(fields);
        } else {
            // Make sure that the enctype and method attributes are set properly
            this.element.setAttribute("enctype", "multipart/form-data");
            this.element.setAttribute("method", this.options.method);
        }
        return form != null ? form : fields;
    }
    // Returns the fallback elements if they exist already
    //
    // This code has to pass in IE7 :(
    getExistingFallback() {
        let getFallback = function(elements) {
            for (let el of elements){
                if (/(^| )fallback($| )/.test(el.className)) return el;
            }
        };
        for (let tagName of [
            "div",
            "form"
        ]){
            var fallback;
            if (fallback = getFallback(this.element.getElementsByTagName(tagName))) return fallback;
        }
    }
    // Activates all listeners stored in @listeners
    setupEventListeners() {
        return this.listeners.map((elementListeners)=>(()=>{
                let result = [];
                for(let event in elementListeners.events){
                    let listener = elementListeners.events[event];
                    result.push(elementListeners.element.addEventListener(event, listener, false));
                }
                return result;
            })()
        );
    }
    // Deactivates all listeners stored in @listeners
    removeEventListeners() {
        return this.listeners.map((elementListeners)=>(()=>{
                let result = [];
                for(let event in elementListeners.events){
                    let listener = elementListeners.events[event];
                    result.push(elementListeners.element.removeEventListener(event, listener, false));
                }
                return result;
            })()
        );
    }
    // Removes all event listeners and cancels all files in the queue or being processed.
    disable() {
        this.clickableElements.forEach((element)=>element.classList.remove("dz-clickable")
        );
        this.removeEventListeners();
        this.disabled = true;
        return this.files.map((file)=>this.cancelUpload(file)
        );
    }
    enable() {
        delete this.disabled;
        this.clickableElements.forEach((element)=>element.classList.add("dz-clickable")
        );
        return this.setupEventListeners();
    }
    // Returns a nicely formatted filesize
    filesize(size) {
        let selectedSize = 0;
        let selectedUnit = "b";
        if (size > 0) {
            let units = [
                "tb",
                "gb",
                "mb",
                "kb",
                "b"
            ];
            for(let i = 0; i < units.length; i++){
                let unit = units[i];
                let cutoff = Math.pow(this.options.filesizeBase, 4 - i) / 10;
                if (size >= cutoff) {
                    selectedSize = size / Math.pow(this.options.filesizeBase, 4 - i);
                    selectedUnit = unit;
                    break;
                }
            }
            selectedSize = Math.round(10 * selectedSize) / 10; // Cutting of digits
        }
        return `<strong>${selectedSize}</strong> ${this.options.dictFileSizeUnits[selectedUnit]}`;
    }
    // Adds or removes the `dz-max-files-reached` class from the form.
    _updateMaxFilesReachedClass() {
        if (this.options.maxFiles != null && this.getAcceptedFiles().length >= this.options.maxFiles) {
            if (this.getAcceptedFiles().length === this.options.maxFiles) this.emit("maxfilesreached", this.files);
            return this.element.classList.add("dz-max-files-reached");
        } else return this.element.classList.remove("dz-max-files-reached");
    }
    drop(e) {
        if (!e.dataTransfer) return;
        this.emit("drop", e);
        // Convert the FileList to an Array
        // This is necessary for IE11
        let files = [];
        for(let i = 0; i < e.dataTransfer.files.length; i++)files[i] = e.dataTransfer.files[i];
        // Even if it's a folder, files.length will contain the folders.
        if (files.length) {
            let { items: items  } = e.dataTransfer;
            if (items && items.length && items[0].webkitGetAsEntry != null) // The browser supports dropping of folders, so handle items instead of files
            this._addFilesFromItems(items);
            else this.handleFiles(files);
        }
        this.emit("addedfiles", files);
    }
    paste(e) {
        if ($3ed269f2f0fb224b$var$__guard__(e != null ? e.clipboardData : undefined, (x)=>x.items
        ) == null) return;
        this.emit("paste", e);
        let { items: items  } = e.clipboardData;
        if (items.length) return this._addFilesFromItems(items);
    }
    handleFiles(files) {
        for (let file of files)this.addFile(file);
    }
    // When a folder is dropped (or files are pasted), items must be handled
    // instead of files.
    _addFilesFromItems(items) {
        return (()=>{
            let result = [];
            for (let item of items){
                var entry;
                if (item.webkitGetAsEntry != null && (entry = item.webkitGetAsEntry())) {
                    if (entry.isFile) result.push(this.addFile(item.getAsFile()));
                    else if (entry.isDirectory) // Append all files from that directory to files
                    result.push(this._addFilesFromDirectory(entry, entry.name));
                    else result.push(undefined);
                } else if (item.getAsFile != null) {
                    if (item.kind == null || item.kind === "file") result.push(this.addFile(item.getAsFile()));
                    else result.push(undefined);
                } else result.push(undefined);
            }
            return result;
        })();
    }
    // Goes through the directory, and adds each file it finds recursively
    _addFilesFromDirectory(directory, path) {
        let dirReader = directory.createReader();
        let errorHandler = (error)=>$3ed269f2f0fb224b$var$__guardMethod__(console, "log", (o)=>o.log(error)
            )
        ;
        var readEntries = ()=>{
            return dirReader.readEntries((entries)=>{
                if (entries.length > 0) {
                    for (let entry of entries){
                        if (entry.isFile) entry.file((file)=>{
                            if (this.options.ignoreHiddenFiles && file.name.substring(0, 1) === ".") return;
                            file.fullPath = `${path}/${file.name}`;
                            return this.addFile(file);
                        });
                        else if (entry.isDirectory) this._addFilesFromDirectory(entry, `${path}/${entry.name}`);
                    }
                    // Recursively call readEntries() again, since browser only handle
                    // the first 100 entries.
                    // See: https://developer.mozilla.org/en-US/docs/Web/API/DirectoryReader#readEntries
                    readEntries();
                }
                return null;
            }, errorHandler);
        };
        return readEntries();
    }
    // If `done()` is called without argument the file is accepted
    // If you call it with an error message, the file is rejected
    // (This allows for asynchronous validation)
    //
    // This function checks the filesize, and if the file.type passes the
    // `acceptedFiles` check.
    accept(file, done) {
        if (this.options.maxFilesize && file.size > this.options.maxFilesize * 1048576) done(this.options.dictFileTooBig.replace("{{filesize}}", Math.round(file.size / 1024 / 10.24) / 100).replace("{{maxFilesize}}", this.options.maxFilesize));
        else if (!$3ed269f2f0fb224b$export$2e2bcd8739ae039.isValidFile(file, this.options.acceptedFiles)) done(this.options.dictInvalidFileType);
        else if (this.options.maxFiles != null && this.getAcceptedFiles().length >= this.options.maxFiles) {
            done(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}", this.options.maxFiles));
            this.emit("maxfilesexceeded", file);
        } else this.options.accept.call(this, file, done);
    }
    addFile(file) {
        file.upload = {
            uuid: $3ed269f2f0fb224b$export$2e2bcd8739ae039.uuidv4(),
            progress: 0,
            // Setting the total upload size to file.size for the beginning
            // It's actual different than the size to be transmitted.
            total: file.size,
            bytesSent: 0,
            filename: this._renameFile(file)
        };
        this.files.push(file);
        file.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.ADDED;
        this.emit("addedfile", file);
        this._enqueueThumbnail(file);
        this.accept(file, (error)=>{
            if (error) {
                file.accepted = false;
                this._errorProcessing([
                    file
                ], error); // Will set the file.status
            } else {
                file.accepted = true;
                if (this.options.autoQueue) this.enqueueFile(file);
                 // Will set .accepted = true
            }
            this._updateMaxFilesReachedClass();
        });
    }
    // Wrapper for enqueueFile
    enqueueFiles(files) {
        for (let file of files)this.enqueueFile(file);
        return null;
    }
    enqueueFile(file) {
        if (file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.ADDED && file.accepted === true) {
            file.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.QUEUED;
            if (this.options.autoProcessQueue) return setTimeout(()=>this.processQueue()
            , 0); // Deferring the call
        } else throw new Error("This file can't be queued because it has already been processed or was rejected.");
    }
    _enqueueThumbnail(file) {
        if (this.options.createImageThumbnails && file.type.match(/image.*/) && file.size <= this.options.maxThumbnailFilesize * 1048576) {
            this._thumbnailQueue.push(file);
            return setTimeout(()=>this._processThumbnailQueue()
            , 0); // Deferring the call
        }
    }
    _processThumbnailQueue() {
        if (this._processingThumbnail || this._thumbnailQueue.length === 0) return;
        this._processingThumbnail = true;
        let file = this._thumbnailQueue.shift();
        return this.createThumbnail(file, this.options.thumbnailWidth, this.options.thumbnailHeight, this.options.thumbnailMethod, true, (dataUrl)=>{
            this.emit("thumbnail", file, dataUrl);
            this._processingThumbnail = false;
            return this._processThumbnailQueue();
        });
    }
    // Can be called by the user to remove a file
    removeFile(file) {
        if (file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING) this.cancelUpload(file);
        this.files = $3ed269f2f0fb224b$var$without(this.files, file);
        this.emit("removedfile", file);
        if (this.files.length === 0) return this.emit("reset");
    }
    // Removes all files that aren't currently processed from the list
    removeAllFiles(cancelIfNecessary) {
        // Create a copy of files since removeFile() changes the @files array.
        if (cancelIfNecessary == null) cancelIfNecessary = false;
        for (let file of this.files.slice())if (file.status !== $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING || cancelIfNecessary) this.removeFile(file);
        return null;
    }
    // Resizes an image before it gets sent to the server. This function is the default behavior of
    // `options.transformFile` if `resizeWidth` or `resizeHeight` are set. The callback is invoked with
    // the resized blob.
    resizeImage(file, width, height, resizeMethod, callback) {
        return this.createThumbnail(file, width, height, resizeMethod, true, (dataUrl, canvas)=>{
            if (canvas == null) // The image has not been resized
            return callback(file);
            else {
                let { resizeMimeType: resizeMimeType  } = this.options;
                if (resizeMimeType == null) resizeMimeType = file.type;
                let resizedDataURL = canvas.toDataURL(resizeMimeType, this.options.resizeQuality);
                if (resizeMimeType === "image/jpeg" || resizeMimeType === "image/jpg") // Now add the original EXIF information
                resizedDataURL = $3ed269f2f0fb224b$var$ExifRestore.restore(file.dataURL, resizedDataURL);
                return callback($3ed269f2f0fb224b$export$2e2bcd8739ae039.dataURItoBlob(resizedDataURL));
            }
        });
    }
    createThumbnail(file, width, height, resizeMethod, fixOrientation, callback) {
        let fileReader = new FileReader();
        fileReader.onload = ()=>{
            file.dataURL = fileReader.result;
            // Don't bother creating a thumbnail for SVG images since they're vector
            if (file.type === "image/svg+xml") {
                if (callback != null) callback(fileReader.result);
                return;
            }
            this.createThumbnailFromUrl(file, width, height, resizeMethod, fixOrientation, callback);
        };
        fileReader.readAsDataURL(file);
    }
    // `mockFile` needs to have these attributes:
    //
    //     { name: 'name', size: 12345, imageUrl: '' }
    //
    // `callback` will be invoked when the image has been downloaded and displayed.
    // `crossOrigin` will be added to the `img` tag when accessing the file.
    displayExistingFile(mockFile, imageUrl, callback, crossOrigin, resizeThumbnail = true) {
        this.emit("addedfile", mockFile);
        this.emit("complete", mockFile);
        if (!resizeThumbnail) {
            this.emit("thumbnail", mockFile, imageUrl);
            if (callback) callback();
        } else {
            let onDone = (thumbnail)=>{
                this.emit("thumbnail", mockFile, thumbnail);
                if (callback) callback();
            };
            mockFile.dataURL = imageUrl;
            this.createThumbnailFromUrl(mockFile, this.options.thumbnailWidth, this.options.thumbnailHeight, this.options.thumbnailMethod, this.options.fixOrientation, onDone, crossOrigin);
        }
    }
    createThumbnailFromUrl(file, width, height, resizeMethod, fixOrientation, callback, crossOrigin) {
        // Not using `new Image` here because of a bug in latest Chrome versions.
        // See https://github.com/enyo/dropzone/pull/226
        let img = document.createElement("img");
        if (crossOrigin) img.crossOrigin = crossOrigin;
        // fixOrientation is not needed anymore with browsers handling imageOrientation
        fixOrientation = getComputedStyle(document.body)["imageOrientation"] == "from-image" ? false : fixOrientation;
        img.onload = ()=>{
            let loadExif = (callback)=>callback(1)
            ;
            if (typeof EXIF !== "undefined" && EXIF !== null && fixOrientation) loadExif = (callback)=>EXIF.getData(img, function() {
                    return callback(EXIF.getTag(this, "Orientation"));
                })
            ;
            return loadExif((orientation)=>{
                file.width = img.width;
                file.height = img.height;
                let resizeInfo = this.options.resize.call(this, file, width, height, resizeMethod);
                let canvas = document.createElement("canvas");
                let ctx = canvas.getContext("2d");
                canvas.width = resizeInfo.trgWidth;
                canvas.height = resizeInfo.trgHeight;
                if (orientation > 4) {
                    canvas.width = resizeInfo.trgHeight;
                    canvas.height = resizeInfo.trgWidth;
                }
                switch(orientation){
                    case 2:
                        // horizontal flip
                        ctx.translate(canvas.width, 0);
                        ctx.scale(-1, 1);
                        break;
                    case 3:
                        // 180° rotate left
                        ctx.translate(canvas.width, canvas.height);
                        ctx.rotate(Math.PI);
                        break;
                    case 4:
                        // vertical flip
                        ctx.translate(0, canvas.height);
                        ctx.scale(1, -1);
                        break;
                    case 5:
                        // vertical flip + 90 rotate right
                        ctx.rotate(0.5 * Math.PI);
                        ctx.scale(1, -1);
                        break;
                    case 6:
                        // 90° rotate right
                        ctx.rotate(0.5 * Math.PI);
                        ctx.translate(0, -canvas.width);
                        break;
                    case 7:
                        // horizontal flip + 90 rotate right
                        ctx.rotate(0.5 * Math.PI);
                        ctx.translate(canvas.height, -canvas.width);
                        ctx.scale(-1, 1);
                        break;
                    case 8:
                        // 90° rotate left
                        ctx.rotate(-0.5 * Math.PI);
                        ctx.translate(-canvas.height, 0);
                        break;
                }
                // This is a bugfix for iOS' scaling bug.
                $3ed269f2f0fb224b$var$drawImageIOSFix(ctx, img, resizeInfo.srcX != null ? resizeInfo.srcX : 0, resizeInfo.srcY != null ? resizeInfo.srcY : 0, resizeInfo.srcWidth, resizeInfo.srcHeight, resizeInfo.trgX != null ? resizeInfo.trgX : 0, resizeInfo.trgY != null ? resizeInfo.trgY : 0, resizeInfo.trgWidth, resizeInfo.trgHeight);
                let thumbnail = canvas.toDataURL("image/png");
                if (callback != null) return callback(thumbnail, canvas);
            });
        };
        if (callback != null) img.onerror = callback;
        return img.src = file.dataURL;
    }
    // Goes through the queue and processes files if there aren't too many already.
    processQueue() {
        let { parallelUploads: parallelUploads  } = this.options;
        let processingLength = this.getUploadingFiles().length;
        let i = processingLength;
        // There are already at least as many files uploading than should be
        if (processingLength >= parallelUploads) return;
        let queuedFiles = this.getQueuedFiles();
        if (!(queuedFiles.length > 0)) return;
        if (this.options.uploadMultiple) // The files should be uploaded in one request
        return this.processFiles(queuedFiles.slice(0, parallelUploads - processingLength));
        else while(i < parallelUploads){
            if (!queuedFiles.length) return;
             // Nothing left to process
            this.processFile(queuedFiles.shift());
            i++;
        }
    }
    // Wrapper for `processFiles`
    processFile(file) {
        return this.processFiles([
            file
        ]);
    }
    // Loads the file, then calls finishedLoading()
    processFiles(files) {
        for (let file of files){
            file.processing = true; // Backwards compatibility
            file.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING;
            this.emit("processing", file);
        }
        if (this.options.uploadMultiple) this.emit("processingmultiple", files);
        return this.uploadFiles(files);
    }
    _getFilesWithXhr(xhr) {
        let files;
        return files = this.files.filter((file)=>file.xhr === xhr
        ).map((file)=>file
        );
    }
    // Cancels the file upload and sets the status to CANCELED
    // **if** the file is actually being uploaded.
    // If it's still in the queue, the file is being removed from it and the status
    // set to CANCELED.
    cancelUpload(file) {
        if (file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING) {
            let groupedFiles = this._getFilesWithXhr(file.xhr);
            for (let groupedFile of groupedFiles)groupedFile.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.CANCELED;
            if (typeof file.xhr !== "undefined") file.xhr.abort();
            for (let groupedFile1 of groupedFiles)this.emit("canceled", groupedFile1);
            if (this.options.uploadMultiple) this.emit("canceledmultiple", groupedFiles);
        } else if (file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.ADDED || file.status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.QUEUED) {
            file.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.CANCELED;
            this.emit("canceled", file);
            if (this.options.uploadMultiple) this.emit("canceledmultiple", [
                file
            ]);
        }
        if (this.options.autoProcessQueue) return this.processQueue();
    }
    resolveOption(option, ...args) {
        if (typeof option === "function") return option.apply(this, args);
        return option;
    }
    uploadFile(file) {
        return this.uploadFiles([
            file
        ]);
    }
    uploadFiles(files) {
        this._transformFiles(files, (transformedFiles)=>{
            if (this.options.chunking) {
                // Chunking is not allowed to be used with `uploadMultiple` so we know
                // that there is only __one__file.
                let transformedFile = transformedFiles[0];
                files[0].upload.chunked = this.options.chunking && (this.options.forceChunking || transformedFile.size > this.options.chunkSize);
                files[0].upload.totalChunkCount = Math.ceil(transformedFile.size / this.options.chunkSize);
            }
            if (files[0].upload.chunked) {
                // This file should be sent in chunks!
                // If the chunking option is set, we **know** that there can only be **one** file, since
                // uploadMultiple is not allowed with this option.
                let file = files[0];
                let transformedFile = transformedFiles[0];
                let startedChunkCount = 0;
                file.upload.chunks = [];
                let handleNextChunk = ()=>{
                    let chunkIndex = 0;
                    // Find the next item in file.upload.chunks that is not defined yet.
                    while(file.upload.chunks[chunkIndex] !== undefined)chunkIndex++;
                    // This means, that all chunks have already been started.
                    if (chunkIndex >= file.upload.totalChunkCount) return;
                    startedChunkCount++;
                    let start = chunkIndex * this.options.chunkSize;
                    let end = Math.min(start + this.options.chunkSize, transformedFile.size);
                    let dataBlock = {
                        name: this._getParamName(0),
                        data: transformedFile.webkitSlice ? transformedFile.webkitSlice(start, end) : transformedFile.slice(start, end),
                        filename: file.upload.filename,
                        chunkIndex: chunkIndex
                    };
                    file.upload.chunks[chunkIndex] = {
                        file: file,
                        index: chunkIndex,
                        dataBlock: dataBlock,
                        status: $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING,
                        progress: 0,
                        retries: 0
                    };
                    this._uploadData(files, [
                        dataBlock
                    ]);
                };
                file.upload.finishedChunkUpload = (chunk, response)=>{
                    let allFinished = true;
                    chunk.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.SUCCESS;
                    // Clear the data from the chunk
                    chunk.dataBlock = null;
                    chunk.response = chunk.xhr.responseText;
                    chunk.responseHeaders = chunk.xhr.getAllResponseHeaders();
                    // Leaving this reference to xhr will cause memory leaks.
                    chunk.xhr = null;
                    for(let i = 0; i < file.upload.totalChunkCount; i++){
                        if (file.upload.chunks[i] === undefined) return handleNextChunk();
                        if (file.upload.chunks[i].status !== $3ed269f2f0fb224b$export$2e2bcd8739ae039.SUCCESS) allFinished = false;
                    }
                    if (allFinished) this.options.chunksUploaded(file, ()=>{
                        this._finished(files, response, null);
                    });
                };
                if (this.options.parallelChunkUploads) for(let i = 0; i < file.upload.totalChunkCount; i++)handleNextChunk();
                else handleNextChunk();
            } else {
                let dataBlocks = [];
                for(let i = 0; i < files.length; i++)dataBlocks[i] = {
                    name: this._getParamName(i),
                    data: transformedFiles[i],
                    filename: files[i].upload.filename
                };
                this._uploadData(files, dataBlocks);
            }
        });
    }
    /// Returns the right chunk for given file and xhr
    _getChunk(file, xhr) {
        for(let i = 0; i < file.upload.totalChunkCount; i++){
            if (file.upload.chunks[i] !== undefined && file.upload.chunks[i].xhr === xhr) return file.upload.chunks[i];
        }
    }
    // This function actually uploads the file(s) to the server.
    //
    //  If dataBlocks contains the actual data to upload (meaning, that this could
    // either be transformed files, or individual chunks for chunked upload) then
    // they will be used for the actual data to upload.
    _uploadData(files, dataBlocks) {
        let xhr = new XMLHttpRequest();
        // Put the xhr object in the file objects to be able to reference it later.
        for (let file of files)file.xhr = xhr;
        if (files[0].upload.chunked) // Put the xhr object in the right chunk object, so it can be associated
        // later, and found with _getChunk.
        files[0].upload.chunks[dataBlocks[0].chunkIndex].xhr = xhr;
        let method = this.resolveOption(this.options.method, files, dataBlocks);
        let url = this.resolveOption(this.options.url, files, dataBlocks);
        xhr.open(method, url, true);
        // Setting the timeout after open because of IE11 issue: https://gitlab.com/meno/dropzone/issues/8
        let timeout = this.resolveOption(this.options.timeout, files);
        if (timeout) xhr.timeout = this.resolveOption(this.options.timeout, files);
        // Has to be after `.open()`. See https://github.com/enyo/dropzone/issues/179
        xhr.withCredentials = !!this.options.withCredentials;
        xhr.onload = (e)=>{
            this._finishedUploading(files, xhr, e);
        };
        xhr.ontimeout = ()=>{
            this._handleUploadError(files, xhr, `Request timedout after ${this.options.timeout / 1000} seconds`);
        };
        xhr.onerror = ()=>{
            this._handleUploadError(files, xhr);
        };
        // Some browsers do not have the .upload property
        let progressObj = xhr.upload != null ? xhr.upload : xhr;
        progressObj.onprogress = (e)=>this._updateFilesUploadProgress(files, xhr, e)
        ;
        let headers = this.options.defaultHeaders ? {
            Accept: "application/json",
            "Cache-Control": "no-cache",
            "X-Requested-With": "XMLHttpRequest"
        } : {
        };
        if (this.options.binaryBody) headers["Content-Type"] = files[0].type;
        if (this.options.headers) (0,just_extend__WEBPACK_IMPORTED_MODULE_0__["default"])(headers, this.options.headers);
        for(let headerName in headers){
            let headerValue = headers[headerName];
            if (headerValue) xhr.setRequestHeader(headerName, headerValue);
        }
        if (this.options.binaryBody) {
            // Since the file is going to be sent as binary body, it doesn't make
            // any sense to generate `FormData` for it.
            for (let file of files)this.emit("sending", file, xhr);
            if (this.options.uploadMultiple) this.emit("sendingmultiple", files, xhr);
            this.submitRequest(xhr, null, files);
        } else {
            let formData = new FormData();
            // Adding all @options parameters
            if (this.options.params) {
                let additionalParams = this.options.params;
                if (typeof additionalParams === "function") additionalParams = additionalParams.call(this, files, xhr, files[0].upload.chunked ? this._getChunk(files[0], xhr) : null);
                for(let key in additionalParams){
                    let value = additionalParams[key];
                    if (Array.isArray(value)) // The additional parameter contains an array,
                    // so lets iterate over it to attach each value
                    // individually.
                    for(let i = 0; i < value.length; i++)formData.append(key, value[i]);
                    else formData.append(key, value);
                }
            }
            // Let the user add additional data if necessary
            for (let file of files)this.emit("sending", file, xhr, formData);
            if (this.options.uploadMultiple) this.emit("sendingmultiple", files, xhr, formData);
            this._addFormElementData(formData);
            // Finally add the files
            // Has to be last because some servers (eg: S3) expect the file to be the last parameter
            for(let i = 0; i < dataBlocks.length; i++){
                let dataBlock = dataBlocks[i];
                formData.append(dataBlock.name, dataBlock.data, dataBlock.filename);
            }
            this.submitRequest(xhr, formData, files);
        }
    }
    // Transforms all files with this.options.transformFile and invokes done with the transformed files when done.
    _transformFiles(files, done) {
        let transformedFiles = [];
        // Clumsy way of handling asynchronous calls, until I get to add a proper Future library.
        let doneCounter = 0;
        for(let i = 0; i < files.length; i++)this.options.transformFile.call(this, files[i], (transformedFile)=>{
            transformedFiles[i] = transformedFile;
            if (++doneCounter === files.length) done(transformedFiles);
        });
    }
    // Takes care of adding other input elements of the form to the AJAX request
    _addFormElementData(formData) {
        // Take care of other input elements
        if (this.element.tagName === "FORM") for (let input of this.element.querySelectorAll("input, textarea, select, button")){
            let inputName = input.getAttribute("name");
            let inputType = input.getAttribute("type");
            if (inputType) inputType = inputType.toLowerCase();
            // If the input doesn't have a name, we can't use it.
            if (typeof inputName === "undefined" || inputName === null) continue;
            if (input.tagName === "SELECT" && input.hasAttribute("multiple")) {
                // Possibly multiple values
                for (let option of input.options)if (option.selected) formData.append(inputName, option.value);
            } else if (!inputType || inputType !== "checkbox" && inputType !== "radio" || input.checked) formData.append(inputName, input.value);
        }
    }
    // Invoked when there is new progress information about given files.
    // If e is not provided, it is assumed that the upload is finished.
    _updateFilesUploadProgress(files, xhr, e) {
        if (!files[0].upload.chunked) // Handle file uploads without chunking
        for (let file of files){
            if (file.upload.total && file.upload.bytesSent && file.upload.bytesSent == file.upload.total) continue;
            if (e) {
                file.upload.progress = 100 * e.loaded / e.total;
                file.upload.total = e.total;
                file.upload.bytesSent = e.loaded;
            } else {
                // No event, so we're at 100%
                file.upload.progress = 100;
                file.upload.bytesSent = file.upload.total;
            }
            this.emit("uploadprogress", file, file.upload.progress, file.upload.bytesSent);
        }
        else {
            // Handle chunked file uploads
            // Chunked upload is not compatible with uploading multiple files in one
            // request, so we know there's only one file.
            let file = files[0];
            // Since this is a chunked upload, we need to update the appropriate chunk
            // progress.
            let chunk = this._getChunk(file, xhr);
            if (e) {
                chunk.progress = 100 * e.loaded / e.total;
                chunk.total = e.total;
                chunk.bytesSent = e.loaded;
            } else {
                // No event, so we're at 100%
                chunk.progress = 100;
                chunk.bytesSent = chunk.total;
            }
            // Now tally the *file* upload progress from its individual chunks
            file.upload.progress = 0;
            file.upload.total = 0;
            file.upload.bytesSent = 0;
            for(let i = 0; i < file.upload.totalChunkCount; i++)if (file.upload.chunks[i] && typeof file.upload.chunks[i].progress !== "undefined") {
                file.upload.progress += file.upload.chunks[i].progress;
                file.upload.total += file.upload.chunks[i].total;
                file.upload.bytesSent += file.upload.chunks[i].bytesSent;
            }
            // Since the process is a percentage, we need to divide by the amount of
            // chunks we've used.
            file.upload.progress = file.upload.progress / file.upload.totalChunkCount;
            this.emit("uploadprogress", file, file.upload.progress, file.upload.bytesSent);
        }
    }
    _finishedUploading(files, xhr, e) {
        let response;
        if (files[0].status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.CANCELED) return;
        if (xhr.readyState !== 4) return;
        if (xhr.responseType !== "arraybuffer" && xhr.responseType !== "blob") {
            response = xhr.responseText;
            if (xhr.getResponseHeader("content-type") && ~xhr.getResponseHeader("content-type").indexOf("application/json")) try {
                response = JSON.parse(response);
            } catch (error) {
                e = error;
                response = "Invalid JSON response from server.";
            }
        }
        this._updateFilesUploadProgress(files, xhr);
        if (!(200 <= xhr.status && xhr.status < 300)) this._handleUploadError(files, xhr, response);
        else if (files[0].upload.chunked) files[0].upload.finishedChunkUpload(this._getChunk(files[0], xhr), response);
        else this._finished(files, response, e);
    }
    _handleUploadError(files, xhr, response) {
        if (files[0].status === $3ed269f2f0fb224b$export$2e2bcd8739ae039.CANCELED) return;
        if (files[0].upload.chunked && this.options.retryChunks) {
            let chunk = this._getChunk(files[0], xhr);
            if ((chunk.retries++) < this.options.retryChunksLimit) {
                this._uploadData(files, [
                    chunk.dataBlock
                ]);
                return;
            } else console.warn("Retried this chunk too often. Giving up.");
        }
        this._errorProcessing(files, response || this.options.dictResponseError.replace("{{statusCode}}", xhr.status), xhr);
    }
    submitRequest(xhr, formData, files) {
        if (xhr.readyState != 1) {
            console.warn("Cannot send this request because the XMLHttpRequest.readyState is not OPENED.");
            return;
        }
        if (this.options.binaryBody) {
            if (files[0].upload.chunked) {
                const chunk = this._getChunk(files[0], xhr);
                xhr.send(chunk.dataBlock.data);
            } else xhr.send(files[0]);
        } else xhr.send(formData);
    }
    // Called internally when processing is finished.
    // Individual callbacks have to be called in the appropriate sections.
    _finished(files, responseText, e) {
        for (let file of files){
            file.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.SUCCESS;
            this.emit("success", file, responseText, e);
            this.emit("complete", file);
        }
        if (this.options.uploadMultiple) {
            this.emit("successmultiple", files, responseText, e);
            this.emit("completemultiple", files);
        }
        if (this.options.autoProcessQueue) return this.processQueue();
    }
    // Called internally when processing is finished.
    // Individual callbacks have to be called in the appropriate sections.
    _errorProcessing(files, message, xhr) {
        for (let file of files){
            file.status = $3ed269f2f0fb224b$export$2e2bcd8739ae039.ERROR;
            this.emit("error", file, message, xhr);
            this.emit("complete", file);
        }
        if (this.options.uploadMultiple) {
            this.emit("errormultiple", files, message, xhr);
            this.emit("completemultiple", files);
        }
        if (this.options.autoProcessQueue) return this.processQueue();
    }
    static uuidv4() {
        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(c) {
            let r = Math.random() * 16 | 0, v = c === "x" ? r : r & 3 | 8;
            return v.toString(16);
        });
    }
    constructor(el, options){
        super();
        let fallback, left;
        this.element = el;
        this.clickableElements = [];
        this.listeners = [];
        this.files = []; // All files
        if (typeof this.element === "string") this.element = document.querySelector(this.element);
        // Not checking if instance of HTMLElement or Element since IE9 is extremely weird.
        if (!this.element || this.element.nodeType == null) throw new Error("Invalid dropzone element.");
        if (this.element.dropzone) throw new Error("Dropzone already attached.");
        // Now add this dropzone to the instances.
        $3ed269f2f0fb224b$export$2e2bcd8739ae039.instances.push(this);
        // Put the dropzone inside the element itself.
        this.element.dropzone = this;
        let elementOptions = (left = $3ed269f2f0fb224b$export$2e2bcd8739ae039.optionsForElement(this.element)) != null ? left : {
        };
        this.options = (0,just_extend__WEBPACK_IMPORTED_MODULE_0__["default"])(true, {
        }, $4ca367182776f80b$export$2e2bcd8739ae039, elementOptions, options != null ? options : {
        });
        this.options.previewTemplate = this.options.previewTemplate.replace(/\n*/g, "");
        // If the browser failed, just call the fallback and leave
        if (this.options.forceFallback || !$3ed269f2f0fb224b$export$2e2bcd8739ae039.isBrowserSupported()) return this.options.fallback.call(this);
        // @options.url = @element.getAttribute "action" unless @options.url?
        if (this.options.url == null) this.options.url = this.element.getAttribute("action");
        if (!this.options.url) throw new Error("No URL provided.");
        if (this.options.acceptedFiles && this.options.acceptedMimeTypes) throw new Error("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.");
        if (this.options.uploadMultiple && this.options.chunking) throw new Error("You cannot set both: uploadMultiple and chunking.");
        if (this.options.binaryBody && this.options.uploadMultiple) throw new Error("You cannot set both: binaryBody and uploadMultiple.");
        // Backwards compatibility
        if (this.options.acceptedMimeTypes) {
            this.options.acceptedFiles = this.options.acceptedMimeTypes;
            delete this.options.acceptedMimeTypes;
        }
        // Backwards compatibility
        if (this.options.renameFilename != null) this.options.renameFile = (file)=>this.options.renameFilename.call(this, file.name, file)
        ;
        if (typeof this.options.method === "string") this.options.method = this.options.method.toUpperCase();
        if ((fallback = this.getExistingFallback()) && fallback.parentNode) // Remove the fallback
        fallback.parentNode.removeChild(fallback);
        // Display previews in the previewsContainer element or the Dropzone element unless explicitly set to false
        if (this.options.previewsContainer !== false) {
            if (this.options.previewsContainer) this.previewsContainer = $3ed269f2f0fb224b$export$2e2bcd8739ae039.getElement(this.options.previewsContainer, "previewsContainer");
            else this.previewsContainer = this.element;
        }
        if (this.options.clickable) {
            if (this.options.clickable === true) this.clickableElements = [
                this.element
            ];
            else this.clickableElements = $3ed269f2f0fb224b$export$2e2bcd8739ae039.getElements(this.options.clickable, "clickable");
        }
        this.init();
    }
}
$3ed269f2f0fb224b$export$2e2bcd8739ae039.initClass();
// This is a map of options for your different dropzones. Add configurations
// to this object for your different dropzone elemens.
//
// Example:
//
//     Dropzone.options.myDropzoneElementId = { maxFilesize: 1 };
//
// And in html:
//
//     <form action="/upload" id="my-dropzone-element-id" class="dropzone"></form>
$3ed269f2f0fb224b$export$2e2bcd8739ae039.options = {
};
// Returns the options for an element or undefined if none available.
$3ed269f2f0fb224b$export$2e2bcd8739ae039.optionsForElement = function(element) {
    // Get the `Dropzone.options.elementId` for this element if it exists
    if (element.getAttribute("id")) return $3ed269f2f0fb224b$export$2e2bcd8739ae039.options[$3ed269f2f0fb224b$var$camelize(element.getAttribute("id"))];
    else return undefined;
};
// Holds a list of all dropzone instances
$3ed269f2f0fb224b$export$2e2bcd8739ae039.instances = [];
// Returns the dropzone for given element if any
$3ed269f2f0fb224b$export$2e2bcd8739ae039.forElement = function(element) {
    if (typeof element === "string") element = document.querySelector(element);
    if ((element != null ? element.dropzone : undefined) == null) throw new Error("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.");
    return element.dropzone;
};
// Looks for all .dropzone elements and creates a dropzone for them
$3ed269f2f0fb224b$export$2e2bcd8739ae039.discover = function() {
    let dropzones;
    if (document.querySelectorAll) dropzones = document.querySelectorAll(".dropzone");
    else {
        dropzones = [];
        // IE :(
        let checkElements = (elements)=>(()=>{
                let result = [];
                for (let el of elements)if (/(^| )dropzone($| )/.test(el.className)) result.push(dropzones.push(el));
                else result.push(undefined);
                return result;
            })()
        ;
        checkElements(document.getElementsByTagName("div"));
        checkElements(document.getElementsByTagName("form"));
    }
    return (()=>{
        let result = [];
        for (let dropzone of dropzones)// Create a dropzone unless auto discover has been disabled for specific element
        if ($3ed269f2f0fb224b$export$2e2bcd8739ae039.optionsForElement(dropzone) !== false) result.push(new $3ed269f2f0fb224b$export$2e2bcd8739ae039(dropzone));
        else result.push(undefined);
        return result;
    })();
};
// Some browsers support drag and drog functionality, but not correctly.
//
// So I created a blocklist of userAgents. Yes, yes. Browser sniffing, I know.
// But what to do when browsers *theoretically* support an API, but crash
// when using it.
//
// This is a list of regular expressions tested against navigator.userAgent
//
// ** It should only be used on browser that *do* support the API, but
// incorrectly **
$3ed269f2f0fb224b$export$2e2bcd8739ae039.blockedBrowsers = [
    // The mac os and windows phone version of opera 12 seems to have a problem with the File drag'n'drop API.
    /opera.*(Macintosh|Windows Phone).*version\/12/i, 
];
// Checks if the browser is supported
$3ed269f2f0fb224b$export$2e2bcd8739ae039.isBrowserSupported = function() {
    let capableBrowser = true;
    if (window.File && window.FileReader && window.FileList && window.Blob && window.FormData && document.querySelector) {
        if (!("classList" in document.createElement("a"))) capableBrowser = false;
        else {
            if ($3ed269f2f0fb224b$export$2e2bcd8739ae039.blacklistedBrowsers !== undefined) // Since this has been renamed, this makes sure we don't break older
            // configuration.
            $3ed269f2f0fb224b$export$2e2bcd8739ae039.blockedBrowsers = $3ed269f2f0fb224b$export$2e2bcd8739ae039.blacklistedBrowsers;
            // The browser supports the API, but may be blocked.
            for (let regex of $3ed269f2f0fb224b$export$2e2bcd8739ae039.blockedBrowsers)if (regex.test(navigator.userAgent)) {
                capableBrowser = false;
                continue;
            }
        }
    } else capableBrowser = false;
    return capableBrowser;
};
$3ed269f2f0fb224b$export$2e2bcd8739ae039.dataURItoBlob = function(dataURI) {
    // convert base64 to raw binary data held in a string
    // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
    let byteString = atob(dataURI.split(",")[1]);
    // separate out the mime component
    let mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
    // write the bytes of the string to an ArrayBuffer
    let ab = new ArrayBuffer(byteString.length);
    let ia = new Uint8Array(ab);
    for(let i = 0, end = byteString.length, asc = 0 <= end; asc ? i <= end : i >= end; asc ? i++ : i--)ia[i] = byteString.charCodeAt(i);
    // write the ArrayBuffer to a blob
    return new Blob([
        ab
    ], {
        type: mimeString
    });
};
// Returns an array without the rejected item
const $3ed269f2f0fb224b$var$without = (list, rejectedItem)=>list.filter((item)=>item !== rejectedItem
    ).map((item)=>item
    )
;
// abc-def_ghi -> abcDefGhi
const $3ed269f2f0fb224b$var$camelize = (str)=>str.replace(/[\-_](\w)/g, (match)=>match.charAt(1).toUpperCase()
    )
;
// Creates an element from string
$3ed269f2f0fb224b$export$2e2bcd8739ae039.createElement = function(string) {
    let div = document.createElement("div");
    div.innerHTML = string;
    return div.childNodes[0];
};
// Tests if given element is inside (or simply is) the container
$3ed269f2f0fb224b$export$2e2bcd8739ae039.elementInside = function(element, container) {
    if (element === container) return true;
     // Coffeescript doesn't support do/while loops
    while(element = element.parentNode){
        if (element === container) return true;
    }
    return false;
};
$3ed269f2f0fb224b$export$2e2bcd8739ae039.getElement = function(el, name) {
    let element;
    if (typeof el === "string") element = document.querySelector(el);
    else if (el.nodeType != null) element = el;
    if (element == null) throw new Error(`Invalid \`${name}\` option provided. Please provide a CSS selector or a plain HTML element.`);
    return element;
};
$3ed269f2f0fb224b$export$2e2bcd8739ae039.getElements = function(els, name) {
    let el, elements;
    if (els instanceof Array) {
        elements = [];
        try {
            for (el of els)elements.push(this.getElement(el, name));
        } catch (e) {
            elements = null;
        }
    } else if (typeof els === "string") {
        elements = [];
        for (el of document.querySelectorAll(els))elements.push(el);
    } else if (els.nodeType != null) elements = [
        els
    ];
    if (elements == null || !elements.length) throw new Error(`Invalid \`${name}\` option provided. Please provide a CSS selector, a plain HTML element or a list of those.`);
    return elements;
};
// Asks the user the question and calls accepted or rejected accordingly
//
// The default implementation just uses `window.confirm` and then calls the
// appropriate callback.
$3ed269f2f0fb224b$export$2e2bcd8739ae039.confirm = function(question, accepted, rejected) {
    if (window.confirm(question)) return accepted();
    else if (rejected != null) return rejected();
};
// Validates the mime type like this:
//
// https://developer.mozilla.org/en-US/docs/HTML/Element/input#attr-accept
$3ed269f2f0fb224b$export$2e2bcd8739ae039.isValidFile = function(file, acceptedFiles) {
    if (!acceptedFiles) return true;
     // If there are no accepted mime types, it's OK
    acceptedFiles = acceptedFiles.split(",");
    let mimeType = file.type;
    let baseMimeType = mimeType.replace(/\/.*$/, "");
    for (let validType of acceptedFiles){
        validType = validType.trim();
        if (validType.charAt(0) === ".") {
            if (file.name.toLowerCase().indexOf(validType.toLowerCase(), file.name.length - validType.length) !== -1) return true;
        } else if (/\/\*$/.test(validType)) {
            // This is something like a image/* mime type
            if (baseMimeType === validType.replace(/\/.*$/, "")) return true;
        } else {
            if (mimeType === validType) return true;
        }
    }
    return false;
};
// Augment jQuery
if (typeof jQuery !== "undefined" && jQuery !== null) jQuery.fn.dropzone = function(options) {
    return this.each(function() {
        return new $3ed269f2f0fb224b$export$2e2bcd8739ae039(this, options);
    });
};
// Dropzone file status codes
$3ed269f2f0fb224b$export$2e2bcd8739ae039.ADDED = "added";
$3ed269f2f0fb224b$export$2e2bcd8739ae039.QUEUED = "queued";
// For backwards compatibility. Now, if a file is accepted, it's either queued
// or uploading.
$3ed269f2f0fb224b$export$2e2bcd8739ae039.ACCEPTED = $3ed269f2f0fb224b$export$2e2bcd8739ae039.QUEUED;
$3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING = "uploading";
$3ed269f2f0fb224b$export$2e2bcd8739ae039.PROCESSING = $3ed269f2f0fb224b$export$2e2bcd8739ae039.UPLOADING; // alias
$3ed269f2f0fb224b$export$2e2bcd8739ae039.CANCELED = "canceled";
$3ed269f2f0fb224b$export$2e2bcd8739ae039.ERROR = "error";
$3ed269f2f0fb224b$export$2e2bcd8739ae039.SUCCESS = "success";
/*

 Bugfix for iOS 6 and 7
 Source: http://stackoverflow.com/questions/11929099/html5-canvas-drawimage-ratio-bug-ios
 based on the work of https://github.com/stomita/ios-imagefile-megapixel

 */ // Detecting vertical squash in loaded image.
// Fixes a bug which squash image vertically while drawing into canvas for some images.
// This is a bug in iOS6 devices. This function from https://github.com/stomita/ios-imagefile-megapixel
let $3ed269f2f0fb224b$var$detectVerticalSquash = function(img) {
    let iw = img.naturalWidth;
    let ih = img.naturalHeight;
    let canvas = document.createElement("canvas");
    canvas.width = 1;
    canvas.height = ih;
    let ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    let { data: data  } = ctx.getImageData(1, 0, 1, ih);
    // search image edge pixel position in case it is squashed vertically.
    let sy = 0;
    let ey = ih;
    let py = ih;
    while(py > sy){
        let alpha = data[(py - 1) * 4 + 3];
        if (alpha === 0) ey = py;
        else sy = py;
        py = ey + sy >> 1;
    }
    let ratio = py / ih;
    if (ratio === 0) return 1;
    else return ratio;
};
// A replacement for context.drawImage
// (args are for source and destination).
var $3ed269f2f0fb224b$var$drawImageIOSFix = function(ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
    let vertSquashRatio = $3ed269f2f0fb224b$var$detectVerticalSquash(img);
    return ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
};
// Based on MinifyJpeg
// Source: http://www.perry.cz/files/ExifRestorer.js
// http://elicon.blog57.fc2.com/blog-entry-206.html
class $3ed269f2f0fb224b$var$ExifRestore {
    static initClass() {
        this.KEY_STR = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    }
    static encode64(input) {
        let output = "";
        let chr1 = undefined;
        let chr2 = undefined;
        let chr3 = "";
        let enc1 = undefined;
        let enc2 = undefined;
        let enc3 = undefined;
        let enc4 = "";
        let i = 0;
        while(true){
            chr1 = input[i++];
            chr2 = input[i++];
            chr3 = input[i++];
            enc1 = chr1 >> 2;
            enc2 = (chr1 & 3) << 4 | chr2 >> 4;
            enc3 = (chr2 & 15) << 2 | chr3 >> 6;
            enc4 = chr3 & 63;
            if (isNaN(chr2)) enc3 = enc4 = 64;
            else if (isNaN(chr3)) enc4 = 64;
            output = output + this.KEY_STR.charAt(enc1) + this.KEY_STR.charAt(enc2) + this.KEY_STR.charAt(enc3) + this.KEY_STR.charAt(enc4);
            chr1 = chr2 = chr3 = "";
            enc1 = enc2 = enc3 = enc4 = "";
            if (!(i < input.length)) break;
        }
        return output;
    }
    static restore(origFileBase64, resizedFileBase64) {
        if (!origFileBase64.match("data:image/jpeg;base64,")) return resizedFileBase64;
        let rawImage = this.decode64(origFileBase64.replace("data:image/jpeg;base64,", ""));
        let segments = this.slice2Segments(rawImage);
        let image = this.exifManipulation(resizedFileBase64, segments);
        return `data:image/jpeg;base64,${this.encode64(image)}`;
    }
    static exifManipulation(resizedFileBase64, segments) {
        let exifArray = this.getExifArray(segments);
        let newImageArray = this.insertExif(resizedFileBase64, exifArray);
        let aBuffer = new Uint8Array(newImageArray);
        return aBuffer;
    }
    static getExifArray(segments) {
        let seg = undefined;
        let x = 0;
        while(x < segments.length){
            seg = segments[x];
            if (seg[0] === 255 & seg[1] === 225) return seg;
            x++;
        }
        return [];
    }
    static insertExif(resizedFileBase64, exifArray) {
        let imageData = resizedFileBase64.replace("data:image/jpeg;base64,", "");
        let buf = this.decode64(imageData);
        let separatePoint = buf.indexOf(255, 3);
        let mae = buf.slice(0, separatePoint);
        let ato = buf.slice(separatePoint);
        let array = mae;
        array = array.concat(exifArray);
        array = array.concat(ato);
        return array;
    }
    static slice2Segments(rawImageArray) {
        let head = 0;
        let segments = [];
        while(true){
            var length;
            if (rawImageArray[head] === 255 & rawImageArray[head + 1] === 218) break;
            if (rawImageArray[head] === 255 & rawImageArray[head + 1] === 216) head += 2;
            else {
                length = rawImageArray[head + 2] * 256 + rawImageArray[head + 3];
                let endPoint = head + length + 2;
                let seg = rawImageArray.slice(head, endPoint);
                segments.push(seg);
                head = endPoint;
            }
            if (head > rawImageArray.length) break;
        }
        return segments;
    }
    static decode64(input) {
        let output = "";
        let chr1 = undefined;
        let chr2 = undefined;
        let chr3 = "";
        let enc1 = undefined;
        let enc2 = undefined;
        let enc3 = undefined;
        let enc4 = "";
        let i = 0;
        let buf = [];
        // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
        let base64test = /[^A-Za-z0-9\+\/\=]/g;
        if (base64test.exec(input)) console.warn("There were invalid base64 characters in the input text.\nValid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\nExpect errors in decoding.");
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while(true){
            enc1 = this.KEY_STR.indexOf(input.charAt(i++));
            enc2 = this.KEY_STR.indexOf(input.charAt(i++));
            enc3 = this.KEY_STR.indexOf(input.charAt(i++));
            enc4 = this.KEY_STR.indexOf(input.charAt(i++));
            chr1 = enc1 << 2 | enc2 >> 4;
            chr2 = (enc2 & 15) << 4 | enc3 >> 2;
            chr3 = (enc3 & 3) << 6 | enc4;
            buf.push(chr1);
            if (enc3 !== 64) buf.push(chr2);
            if (enc4 !== 64) buf.push(chr3);
            chr1 = chr2 = chr3 = "";
            enc1 = enc2 = enc3 = enc4 = "";
            if (!(i < input.length)) break;
        }
        return buf;
    }
}
$3ed269f2f0fb224b$var$ExifRestore.initClass();
/*
 * contentloaded.js
 *
 * Author: Diego Perini (diego.perini at gmail.com)
 * Summary: cross-browser wrapper for DOMContentLoaded
 * Updated: 20101020
 * License: MIT
 * Version: 1.2
 *
 * URL:
 * http://javascript.nwbox.com/ContentLoaded/
 * http://javascript.nwbox.com/ContentLoaded/MIT-LICENSE
 */ // @win window reference
// @fn function reference
let $3ed269f2f0fb224b$var$contentLoaded = function(win, fn) {
    let done = false;
    let top = true;
    let doc = win.document;
    let root = doc.documentElement;
    let add = doc.addEventListener ? "addEventListener" : "attachEvent";
    let rem = doc.addEventListener ? "removeEventListener" : "detachEvent";
    let pre = doc.addEventListener ? "" : "on";
    var init = function(e) {
        if (e.type === "readystatechange" && doc.readyState !== "complete") return;
        (e.type === "load" ? win : doc)[rem](pre + e.type, init, false);
        if (!done && (done = true)) return fn.call(win, e.type || e);
    };
    var poll = function() {
        try {
            root.doScroll("left");
        } catch (e) {
            setTimeout(poll, 50);
            return;
        }
        return init("poll");
    };
    if (doc.readyState !== "complete") {
        if (doc.createEventObject && root.doScroll) {
            try {
                top = !win.frameElement;
            } catch (error) {
            }
            if (top) poll();
        }
        doc[add](pre + "DOMContentLoaded", init, false);
        doc[add](pre + "readystatechange", init, false);
        return win[add](pre + "load", init, false);
    }
};
function $3ed269f2f0fb224b$var$__guard__(value, transform) {
    return typeof value !== "undefined" && value !== null ? transform(value) : undefined;
}
function $3ed269f2f0fb224b$var$__guardMethod__(obj, methodName, transform) {
    if (typeof obj !== "undefined" && obj !== null && typeof obj[methodName] === "function") return transform(obj, methodName);
    else return undefined;
}



//# sourceMappingURL=dropzone.mjs.map


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			id: moduleId,
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/nonce */
/******/ 	(() => {
/******/ 		__webpack_require__.nc = undefined;
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;