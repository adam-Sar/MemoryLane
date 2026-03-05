@extends('layouts.app')

@section('content')
<style>
    .create-page {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--neon-cyan), var(--neon-purple), var(--neon-pink));
    }

    .page-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .upload-section {
        background: var(--bg-input);
        border: 2px dashed var(--border);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s;
    }

    .upload-section:hover {
        border-color: var(--neon-cyan);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.1);
    }

    .upload-section.has-file {
        border-style: solid;
        border-color: var(--neon-cyan);
        background: rgba(0, 255, 255, 0.05);
    }

    .upload-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .upload-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-title {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-main);
    }

    .upload-area {
        text-align: center;
        cursor: pointer;
        position: relative;
    }

    .upload-area input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-placeholder {
        padding: 2rem;
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .upload-placeholder svg {
        margin-bottom: 0.5rem;
        color: var(--neon-cyan);
    }

    .preview-container {
        margin-top: 1rem;
        position: relative;
        display: none;
    }

    .preview-container.has-image {
        display: block;
    }

    .preview-image {
        max-width: 100%;
        max-height: 300px;
        border-radius: var(--radius-md);
        border: 2px solid var(--border);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }

    .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: rgba(255, 0, 0, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .remove-btn:hover {
        background: #ff0000;
        transform: scale(1.1);
    }
    
    .doodle-mode-toggle {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .mode-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: var(--bg-input);
        border: 2px solid var(--border);
        border-radius: var(--radius-md);
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .mode-btn:hover {
        border-color: var(--text-muted);
        color: var(--text-main);
    }
    
    .mode-btn.active {
        background: linear-gradient(135deg, var(--neon-purple), var(--neon-pink));
        border-color: var(--neon-purple);
        color: #fff;
        box-shadow: 0 0 15px rgba(176, 38, 255, 0.3);
    }
    
    .doodle-draw-container {
        background: rgba(0, 0, 0, 0.3);
        border-radius: var(--radius-md);
        padding: 1rem;
        border: 2px solid var(--border);
    }
    
    .canvas-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .tool-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .tool-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-input);
        border: 2px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .tool-btn:hover {
        border-color: var(--neon-cyan);
        color: var(--neon-cyan);
        box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
    }
    
    .tool-btn.active {
        background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
        border-color: var(--neon-cyan);
        color: #fff;
    }
    
    .color-picker {
        width: 40px;
        height: 36px;
        border: none;
        border-radius: var(--radius-sm);
        cursor: pointer;
        padding: 0;
    }
    
    .size-slider {
        width: 100px;
        height: 36px;
        cursor: pointer;
    }
    
    #doodle-canvas {
        width: 100%;
        height: auto;
        background: #1a1a2e;
        border: 2px solid var(--border);
        border-radius: var(--radius-md);
        cursor: crosshair;
        display: block;
    }
    
    @media (max-width: 768px) {
        .canvas-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .tool-group {
            justify-content: center;
        }
    }

    .button-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }

    @media (max-width: 768px) {
        .create-page {
            padding: 1rem 0;
        }

        .form-card {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }
    }
</style>

<div class="create-page">
    <div class="page-header">
        <h1 class="page-title">Create New Post</h1>
        <p class="page-subtitle">Help the community find that forgotten game!</p>
    </div>

    <form action="{{ route('create.post') }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        
        <!-- Title -->
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label">Subject</label>
            <input 
                type="text" 
                name="title" 
                class="form-control" 
                required 
                placeholder="e.g. PS2 RPG where you play as a dragon..."
                style="font-size: 1.1rem;"
            >
        </div>

        <!-- Body -->
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label">Details</label>
            <textarea 
                name="body" 
                class="form-control" 
                rows="8" 
                required 
                placeholder="Describe everything you remember (Platform, Year, Characters, Gameplay mechanics, Art style)..."
                style="font-size: 1rem; line-height: 1.7;"
            ></textarea>
        </div>

        <!-- Tag -->
        <div class="form-group" style="margin-bottom: 2rem;">
            <label class="form-label">Game Category</label>
            <select name="tag" class="form-control" style="font-size: 1rem;">
                @foreach (['Battle-Royale','RTS','RPG','FPS','Action','Sports','Mobile'] as $tag)
                    <option value="{{$tag}}">{{$tag}}</option>
                @endforeach
            </select>
        </div>

        <!-- Screenshot Upload -->
        <div class="upload-section" id="screenshot-section">
            <div class="upload-header">
                <div class="upload-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
                <div class="upload-title">Screenshot (Optional)</div>
            </div>
            <div class="upload-area">
                <div class="upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <div>Click to upload screenshot</div>
                    <div style="font-size: 0.8rem; margin-top: 0.5rem;">PNG, JPG, GIF up to 5MB</div>
                </div>
                <input type="file" name="screenshot" accept="image/*" onchange="previewImage(this, 'screenshot-preview', 'screenshot-section')">
            </div>
            <div class="preview-container" id="screenshot-preview">
                <img src="" alt="Screenshot preview" class="preview-image">
                <button type="button" class="remove-btn" onclick="removeImage('screenshot', 'screenshot-preview', 'screenshot-section')">✕</button>
            </div>
        </div>

        <!-- Doodle Section -->
        <div class="upload-section" id="doodle-section" style="margin-top: 1.5rem;">
            <div class="upload-header">
                <div class="upload-icon" style="background: linear-gradient(135deg, var(--neon-purple), var(--neon-pink));">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        <line x1="3" y1="3" x2="21" y2="21"/>
                    </svg>
                </div>
                <div class="upload-title">Doodle / Sketch (Optional)</div>
            </div>
            
            <!-- Doodle Mode Toggle -->
            <div class="doodle-mode-toggle">
                <button type="button" class="mode-btn active" data-mode="draw" onclick="switchDoodleMode('draw')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                        <path d="M12 9v4"/>
                        <path d="M12 17h.01"/>
                    </svg>
                    Draw
                </button>
                <button type="button" class="mode-btn" data-mode="upload" onclick="switchDoodleMode('upload')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    Upload
                </button>
            </div>
            
            <!-- Drawing Canvas -->
            <div class="doodle-draw-container" id="doodle-draw-container">
                <div class="canvas-toolbar">
                    <div class="tool-group">
                        <button type="button" class="tool-btn active" data-tool="pen" onclick="setTool('pen')" title="Pen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9.06 11.9 8.07-8.06a2.85 2.85 0 1 1 4.03 4.03l-1.43 1.43"/>
                                <path d="M7.07 14.94l-3.18.03 1.2 1.2-3.18"/>
                            </svg>
                        </button>
                        <button type="button" class="tool-btn" data-tool="eraser" onclick="setTool('eraser')" title="Eraser">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"/>
                                <path d="M22 21H7"/>
                                <path d="m5 11 9 9"/>
                            </svg>
                        </button>
                    </div>
                    <div class="tool-group">
                        <input type="color" class="color-picker" value="#ffffff" onchange="setColor(this.value)">
                        <input type="range" class="size-slider" min="1" max="20" value="3" onchange="setSize(this.value)">
                    </div>
                    <div class="tool-group">
                        <button type="button" class="tool-btn" onclick="clearCanvas()" title="Clear Canvas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <canvas id="doodle-canvas" width="600" height="400"></canvas>
                <input type="hidden" name="doodle_data" id="doodle-data">
            </div>
            
            <!-- Upload Area -->
            <div class="doodle-upload-container" id="doodle-upload-container" style="display: none;">
                <div class="upload-area">
                    <div class="upload-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        <div>Click to upload your sketch</div>
                        <div style="font-size: 0.8rem; margin-top: 0.5rem;">PNG, JPG, GIF up to 5MB</div>
                    </div>
                    <input type="file" name="doodle" accept="image/*" onchange="previewImage(this, 'doodle-preview', 'doodle-section')">
                </div>
                <div class="preview-container" id="doodle-preview">
                    <img src="" alt="Doodle preview" class="preview-image">
                    <button type="button" class="remove-btn" onclick="removeImage('doodle', 'doodle-preview', 'doodle-section')">✕</button>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-group">
            <a href="{{ route('home') }}" class="btn btn-flat">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Post</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Canvas Drawing Variables
let canvas, ctx;
let isDrawing = false;
let currentTool = 'pen';
let currentColor = '#ffffff';
let currentSize = 3;
let lastX = 0;
let lastY = 0;

// Initialize Canvas
document.addEventListener('DOMContentLoaded', function() {
    canvas = document.getElementById('doodle-canvas');
    if (!canvas) return;
    
    ctx = canvas.getContext('2d');
    
    // Set initial canvas background
    ctx.fillStyle = '#1a1a2e';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Mouse events
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);
    
    // Touch events for mobile
    canvas.addEventListener('touchstart', handleTouch);
    canvas.addEventListener('touchmove', handleTouch);
    canvas.addEventListener('touchend', stopDrawing);
    
    // Save canvas on form submit
    document.querySelector('form').addEventListener('submit', saveCanvas);
});

// Start drawing
function startDrawing(e) {
    isDrawing = true;
    const rect = canvas.getBoundingClientRect();
    const scaleX = canvas.width / rect.width;
    const scaleY = canvas.height / rect.height;
    
    lastX = (e.clientX - rect.left) * scaleX;
    lastY = (e.clientY - rect.top) * scaleY;
}

// Draw
function draw(e) {
    if (!isDrawing) return;
    
    const rect = canvas.getBoundingClientRect();
    const scaleX = canvas.width / rect.width;
    const scaleY = canvas.height / rect.height;
    
    const x = (e.clientX - rect.left) * scaleX;
    const y = (e.clientY - rect.top) * scaleY;
    
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(x, y);
    
    if (currentTool === 'eraser') {
        ctx.globalCompositeOperation = 'destination-out';
        ctx.lineWidth = currentSize * 3;
        ctx.strokeStyle = 'rgba(0,0,0,1)';
    } else {
        ctx.globalCompositeOperation = 'source-over';
        ctx.strokeStyle = currentColor;
        ctx.lineWidth = currentSize;
    }
    
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.stroke();
    
    lastX = x;
    lastY = y;
}

// Stop drawing
function stopDrawing() {
    isDrawing = false;
}

// Touch events for mobile
function handleTouch(e) {
    e.preventDefault();
    const touch = e.touches[0];
    const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 'mousemove', {
        clientX: touch.clientX,
        clientY: touch.clientY
    });
    
    if (e.type === 'touchstart') {
        startDrawing(mouseEvent);
    } else {
        draw(mouseEvent);
    }
}

// Switch doodle mode (draw vs upload)
function switchDoodleMode(mode) {
    const drawContainer = document.getElementById('doodle-draw-container');
    const uploadContainer = document.getElementById('doodle-upload-container');
    const modeBtns = document.querySelectorAll('.mode-btn');
    
    modeBtns.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.mode === mode) {
            btn.classList.add('active');
        }
    });
    
    if (mode === 'draw') {
        drawContainer.style.display = 'block';
        uploadContainer.style.display = 'none';
    } else {
        drawContainer.style.display = 'none';
        uploadContainer.style.display = 'block';
    }
}

// Set drawing tool
function setTool(tool) {
    currentTool = tool;
    const toolBtns = document.querySelectorAll('[data-tool]');
    
    toolBtns.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.tool === tool) {
            btn.classList.add('active');
        }
    });
}

// Set color
function setColor(color) {
    currentColor = color;
}

// Set brush size
function setSize(size) {
    currentSize = parseInt(size);
}

// Clear canvas
function clearCanvas() {
    ctx.fillStyle = '#1a1a2e';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.globalCompositeOperation = 'source-over';
}

// Save canvas to hidden input
function saveCanvas() {
    const drawContainer = document.getElementById('doodle-draw-container');
    if (drawContainer.style.display !== 'none') {
        const dataUrl = canvas.toDataURL('image/png');
        document.getElementById('doodle-data').value = dataUrl;
    }
}

// Preview image for upload
function previewImage(input, previewId, sectionId) {
    const preview = document.getElementById(previewId);
    const section = document.getElementById(sectionId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.add('has-image');
            section.classList.add('has-file');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove image
function removeImage(inputName, previewId, sectionId) {
    const input = document.querySelector(`input[name="${inputName}"]`);
    const preview = document.getElementById(previewId);
    const section = document.getElementById(sectionId);
    
    input.value = '';
    preview.classList.remove('has-image');
    section.classList.remove('has-file');
}
</script>
@endpush
@endsection