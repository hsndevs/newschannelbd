#!/bin/bash

# Build script to compile blocks from src to build directory
echo "Building blocks..."

# Create build directory if it doesn't exist
mkdir -p build/blocks

# List of blocks to build
blocks=(
    "testimonial-item"
    "testimonials"
    "report-by"
    "ncbd-category"
    "button-icon"
    "case-study"
    "latest-post-block"
    "marquee-news"
    "ncb-navigation"
)

# Build each block
for block in "${blocks[@]}"; do
    if [ -d "src/blocks/$block" ]; then
        echo "Building $block..."

        # Create build directory for block
        mkdir -p "build/blocks/$block"

        # Copy PHP files
        if [ -f "src/blocks/$block/render.php" ]; then
            cp "src/blocks/$block/render.php" "build/blocks/$block/"
        fi

        # Copy block.json
        if [ -f "src/blocks/$block/block.json" ]; then
            cp "src/blocks/$block/block.json" "build/blocks/$block/"
        fi

        echo "$block built successfully"
    else
        echo "Warning: $block source directory not found"
    fi
done

echo "Build complete!"
echo "Run 'npm run build' to compile JavaScript and CSS files"
