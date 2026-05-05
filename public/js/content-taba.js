window.addEventListener("load", async function () {
    if (!window.ContentTools) {
        console.error("ContentTools library is not loaded.");
        return;
    }

    try {
        // Fetch translations and initialize the editor
        const translationMap = await fetchAndApplyTranslations();

        // Initialize ContentTools editor
        const editor = ContentTools.EditorApp.get();
        editor.init("[data-translation-key]", "data-translation-key");

        // Listen for the 'saved' event
        editor.addEventListener("saved", async (ev) => {
            const regions = ev.detail().regions;
            if (Object.keys(regions).length === 0) return;

            const payload = {};

            for (let key in regions) {
                if (regions.hasOwnProperty(key)) {
                    // Clean up the updated text: remove all leading/trailing whitespace and newlines
                    const updatedText = cleanText(regions[key]);
                    const realKey = translationMap.getRealKey(key); // Get the real key
                    const originalText = translationMap.get(realKey);

                    // Validate that both originalText and updatedText are non-empty strings
                    if (
                        typeof originalText === "string" &&
                        cleanText(originalText) !== "" &&
                        typeof updatedText === "string"
                    ) {
                        // If updatedText is empty after cleaning, set it to '0000'
                        const newText =
                            updatedText === "" ? "0000" : updatedText;

                        if (
                            originalText !== newText &&
                            stripTags(newText).trim() !== ""
                        ) {
                            payload[realKey] = {
                                old: originalText,
                                new: stripTags(newText).trim(),
                            };
                        }
                    } else {
                        console.warn(
                            `Invalid or empty text for key: ${realKey}`
                        );
                        console.warn(`Original Text: "${originalText}"`);
                        console.warn(`Updated Text: "${updatedText}"`);
                    }
                }
            }

            if (Object.keys(payload).length === 0) {
                console.error("No changes to save.");
                return;
            }

            try {
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content");
                const response = await fetch("/api/translations", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({ updates: payload }),
                });
                console.log("Payload:", JSON.stringify({ updates: payload }));

                if (!response.ok) {
                    console.error("Save Error:", response.status);
                    console.error(
                        "Error saving content. Check the console for details."
                    );
                } else {
                    console.log("Content saved successfully!");
                    for (const key in payload) {
                        translationMap.set(key, payload[key].new); // Update the local translation map
                    }
                    location.reload();
                }
            } catch (error) {
                console.error("Network Error:", error);
                console.error("Network error. Please check your connection.");
            }
        });

        // Helper function to clean text: remove all leading/trailing whitespace and newlines
        function cleanText(text) {
            return text.replace(/^\s+|\s+$/g, "").replace(/\n/g, "");
        }
    } catch (error) {
        console.error("Initialization error:", error);
        console.error(
            "Failed to initialize the page. Check the console for details."
        );
    }
});

// Helper function to clean text: remove all leading/trailing whitespace and newlines
function cleanText(text) {
    return text.replace(/^\s+|\s+$/g, "").replace(/\n/g, "");
}

// Helper function to strip HTML tags
function stripTags(html) {
    const div = document.createElement("div");
    div.innerHTML = html;
    return div.textContent || div.innerText || "";
}

// Function to fetch translations and apply them
async function fetchAndApplyTranslations() {
    const translationMap = new TranslationMap();

    try {
        const response = await fetch("/api/translations");
        if (!response.ok) {
            throw new Error(
                `Failed to load translations. Status: ${response.status}`
            );
        }

        const translations = await response.json();

        // Process all text nodes in the document
        document.querySelectorAll("body *").forEach((element) => {
            if (element.childNodes.length === 0) return; // Skip empty elements

            // Extract text content, including <br> tags
            const textContent = Array.from(element.childNodes)
                .map((node) => {
                    if (node.nodeType === Node.TEXT_NODE) {
                        return node.textContent.trim();
                    } else if (node.nodeName === "BR") {
                        return "\n"; // Replace <br> with newline
                    }
                    return "";
                })
                .filter((text) => text) // Remove empty strings
                .join(" ");

            if (!textContent) return; // Skip elements with no text

            // Find the real key for this text
            const realKey = findTranslationKey(translations, textContent);
            if (!realKey) {
                console.warn(
                    `No matching key found for content: "${textContent}"`
                );
                return;
            }

            // Generate a unique key for the element
            const dynamicKey = `key_${Math.random().toString(36).substr(2, 9)}`;

            // Set the data-translation-key attribute
            element.setAttribute("data-translation-key", dynamicKey);

            // Map the dynamic key to the real key
            translationMap.setRealKey(dynamicKey, realKey);

            // Apply translations if available
            const tag = element.tagName.toLowerCase();
            if (translations[tag] && translations[tag][realKey]) {
                element.innerHTML = translations[tag][realKey];
                translationMap.set(realKey, translations[tag][realKey]);
            } else {
                translationMap.set(realKey, textContent);
            }
        });
    } catch (error) {
        console.error("Error fetching translations:", error);
    }

    return translationMap;
}

// Helper function to find the translation key for a given text
function findTranslationKey(translations, text) {
    for (const category in translations) {
        for (const key in translations[category]) {
            if (translations[category][key] === text) {
                return category + "." + key;
            }
        }
    }
    return null;
}

// Helper function to strip HTML tags
function stripTags(html) {
    const div = document.createElement("div");
    div.innerHTML = html;
    return div.textContent || div.innerText || "";
}

function disableAllLinks() {
    // Select all <a> tags on the page
    const links = document.querySelectorAll("a");

    // Loop through each link and modify its behavior
    links.forEach((link) => {
        // Set href to javascript:void(0) to prevent scrolling
        link.href = "javascript:void(0)";

        // Add an event listener to prevent default behavior
        link.addEventListener("click", (event) => {
            event.preventDefault(); // Prevent the default link behavior
        });
    });

    console.log("All links have been disabled.");
}

// Call the function to disable all links
disableAllLinks();

// Extend Map to store real keys
class TranslationMap extends Map {
    constructor() {
        super();
        this.realKeys = new Map();
    }

    setRealKey(dynamicKey, realKey) {
        this.realKeys.set(dynamicKey, realKey);
    }

    getRealKey(dynamicKey) {
        return this.realKeys.get(dynamicKey);
    }
}
