import hljs from 'highlight.js/lib/common';
import 'highlight.js/styles/github-dark.css';

export function highlight(element) {
    const language = element.dataset.syntax.toLowerCase();
    const source = element.textContent;
    const highlighted = hljs.getLanguage(language)
        ? hljs.highlight(source, { language })
        : hljs.highlightAuto(source);
    element.innerHTML = highlighted.value;
}
