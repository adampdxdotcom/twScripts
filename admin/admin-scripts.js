// admin/admin-scripts.js

document.addEventListener('DOMContentLoaded', function () {

    const selector = document.getElementById('tw-script-selector');
    const copyButtons = document.querySelectorAll('.tw-scripts-copy-btn');

    // --- 1. Dropdown Change Handler ---
    if (selector) {
        // Function to show/hide code blocks based on selection
        function updateVisibleScript() {
            const selectedValue = selector.value;
            const allCodeBlocks = document.querySelectorAll('.tw-scripts-file-container');

            allCodeBlocks.forEach(block => {
                if (block.id === selectedValue) {
                    block.hidden = false;
                } else {
                    block.hidden = true;
                }
            });
        }

        // Add event listener to the dropdown
        selector.addEventListener('change', updateVisibleScript);

        // Run it once on page load to set the initial state
        updateVisibleScript();
    }

    // --- 2. Copy Button Click Handler ---
    if (copyButtons.length > 0) {
        copyButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.dataset.target;
                const codeElement = document.getElementById(targetId);

                if (codeElement) {
                    // Use the modern Clipboard API
                    navigator.clipboard.writeText(codeElement.textContent).then(() => {
                        // Success feedback
                        const originalText = this.textContent;
                        this.textContent = 'Copied!';
                        this.classList.add('copied');

                        // Revert the button text after 2 seconds
                        setTimeout(() => {
                            this.textContent = originalText;
                            this.classList.remove('copied');
                        }, 2000);
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                        // Optional: Provide fallback for older browsers or error feedback
                    });
                }
            });
        });
    }
});
